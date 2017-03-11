<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Entities\AuthCommand;
use App\Jobs\CreateAuthCommandClass;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер авторизации пользователей в приложении.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthController extends Controller {
	/**
	 * Получение кода авторизации.
	 *
	 * @param string $appUuid   UUID приложения
	 * @param string $callback  Название callback-функции для выполнения на клиенте
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(string $appUuid, string $callback) {
		/** @var Application $application */
		$application = Application::find($appUuid);
		if (null === $application) {
			return response()->jsonp($callback, ['error' => 'Приложение не найдено']);
		}

		$authCommand = AuthCommand::create([AuthCommand::APPLICATION_UUID => $appUuid]);
		$this->dispatchNow(new CreateAuthCommandClass($authCommand));

		return response()->jsonp($callback, [
			'command' => $authCommand->command,
			'expired' => $authCommand::EXPIRED_TIME_SEC,
		]);
	}
}