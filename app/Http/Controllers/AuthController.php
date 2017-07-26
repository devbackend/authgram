<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Entities\AuthCommand;
use App\Entities\LogAuthAttempt;
use App\Jobs\CreateAuthCommandClass;
use App\Providers\RouteServiceProvider;
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
		$this->cache->put($cacheKey, $authCommand, 1);
		$this->dispatchNow(new CreateAuthCommandClass($authCommand));

		//-- Логируем попытку авторизации
		$additionalInfo = ['user_ip' => $request->ip()];

		$authAttempt = LogAuthAttempt::create([
			LogAuthAttempt::STEP                => LogAuthAttempt::STEP_GET_CODE,
			LogAuthAttempt::APPLICATION_UUID    => $appUuid,
			LogAuthAttempt::COMMAND             => $authCommand->command,
			LogAuthAttempt::ADDITIONAL_INFO     => json_encode($additionalInfo),
		]);
		$authAttempt->save();
		//-- -- -- --

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