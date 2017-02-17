<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Entities\AuthCode;
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
	 * @param string $appUuid UUID приложения
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(string $appUuid) {
		$application = Application::find($appUuid);
		if (null === $application) {
			return response()->json(['error' => 'Приложение не найдено']);
		}

		$authCode = AuthCode::create([AuthCode::APPLICATION_UUID => $appUuid]);

		return response()->jsonp('AuthoriseWidget.showCode', [
			'code' => $authCode->code,
		]);
	}
}