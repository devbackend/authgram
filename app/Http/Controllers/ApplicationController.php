<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Http\Requests\CreateApplicationRequest;
use App\Wrappers\JsonResponseWrapper;
use Exception;
use Illuminate\Http\JsonResponse;
use Request;

/**
 * Контроллер для управления приложениями.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationController extends Controller {
	/**
	 * Создание приложения.
	 *
	 * @param CreateApplicationRequest $request Данные запроса на создание приложения
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function createAction(CreateApplicationRequest $request) {
		$jsonResponse = new JsonResponseWrapper;

		try {
			$application = Application::createByRequest($request);
		}
		catch (Exception $e) {
			$jsonResponse->text = $e->getMessage();

			return response()->json($jsonResponse);
		}

		$jsonResponse->status = true;
		$jsonResponse->data   = ['token' => $application->api_token];

		return response()->json($jsonResponse);
	}

	/**
	 * Удаление приложения.
	 *
	 * @param Request $request Данные запроса
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function deleteAction(Request $request) {

	}
}