<?php
namespace App\Http\Controllers\Api\v1;

use App\Entities\Application;
use App\Entities\AuthCode;
use App\Http\Controllers\Controller;
use Auth;
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
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function signAction() {
		/** @var Application $application */
		$application = Auth::guard('api')->user();

		$authCode = AuthCode::create([AuthCode::APPLICATION_UUID => $application->uuid]);

		return response()->json([
			'code' => $authCode->code,
		]);
	}
}