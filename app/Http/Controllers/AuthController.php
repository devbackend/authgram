<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Entities\AuthCommand;
use App\Entities\LogAuthAttempt;
use App\Jobs\CreateAuthCommandClass;
use Illuminate\Http\JsonResponse;
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

		$authCommand = AuthCommand::create([AuthCommand::APPLICATION_UUID => $appUuid]);
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
}