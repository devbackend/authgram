<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Entities\AuthCommand;
use App\Jobs\CreateAuthCommandClass;
use App\Providers\RouteServiceProvider;
use App\Repositories\LogAuthStepRepository;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Контроллер авторизации пользователей в приложении.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthController extends Controller {
	/**
	 * Получение кода авторизации.
	 *
	 * @param string  $appUuid  UUID приложения
	 * @param string  $callback Название callback-функции для выполнения на клиенте
	 * @param Request $request  Данные запроса
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(string $appUuid, string $callback, Request $request) {
		/** @var Application $application */
		$application = Application::find($appUuid);
		if (null === $application) {
			return response()->jsonp($callback, ['error' => 'Приложение не найдено']);
		}

		$authCommand = new AuthCommand;
		$authCommand->applicationUuid   = $appUuid;
		$authCommand->command           = AuthCommand::generateCommandName();

		$cacheKey = AuthCommand::getKeyName($authCommand->command);

		// Записываем команду на 5 минут - по факту будет произведена проверка - устарела она или нет
		$this->cache->put($cacheKey, $authCommand, 5);

		$this->dispatchNow(new CreateAuthCommandClass($authCommand));

		// -- Логируем получение кода
		/** @var LogAuthStepRepository $authSteps */
		$authSteps = app(LogAuthStepRepository::class);

		$authSteps->writeCodeStep($authCommand);
		// -- -- -- --

		return response()->jsonp($callback, [
			'command' => $authCommand->command,
			'expired' => $authCommand::EXPIRED_TIME_SEC,
		]);
	}

	/**
	 * Выход из ЛК
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function logoutAction() {
		Auth::logout();

		return redirect()->route(RouteServiceProvider::ROUTE_NAME_HOMEPAGE);
	}
}