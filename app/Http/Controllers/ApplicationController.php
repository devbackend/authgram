<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Http\Requests\application\ApplicationCreateRequest;
use App\Wrappers\JsonResponseWrapper;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для управления приложениями.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationController extends Controller {
	/**
	 * Создание приложения.
	 *
	 * @param ApplicationCreateRequest $request Данные запроса на создание приложения
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function createAction(ApplicationCreateRequest $request) {
		$jsonResponse = new JsonResponseWrapper;

		try {
			$application = Application::createByRequest($request);
		}
		catch (Exception $e) {
			$jsonResponse->text = $e->getMessage();

			return response()->json($jsonResponse);
		}

		$jsonResponse->status = true;
		$jsonResponse->data   = [
			'uuid'  => $application->uuid,
			'token' => $application->api_token,
		];

		$jsonResponse->text = e(view('application.widget-content', ['application' => $application])->render());

		return response()->json($jsonResponse);
	}
}