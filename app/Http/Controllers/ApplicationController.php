<?php
namespace App\Http\Controllers;

use App\Entities\Application;
use App\Http\Requests\application\ApplicationCreateRequest;
use App\Http\Requests\application\ApplicationUpdateRequest;
use App\Wrappers\JsonResponseWrapper;
use Auth;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

	/**
	 * Входная точка управления приложениями.
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function index() {
		$applications = Application::orderBy(Application::CREATED_AT, SORT_DESC)->where(Application::OWNER_UUID, Auth::user()->user_uuid);

		return $this->render('index', ['applications' => $applications->get()]);
	}

	/**
	 * Страница приложения
	 *
	 * @param string $uuid Идентификатор приложения
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function show($uuid) {
		/** @var Application $application */
		$application = Application::where(Application::UUID, $uuid)->first();

		if (null === $application || false === $application->isAvailableForCurrentUser()) {
			throw new NotFoundHttpException();
		}

		return $this->render('view', ['application' => $application]);
	}

	/**
	 * Обновление приложения.
	 *
	 * @param ApplicationUpdateRequest $request
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function update(ApplicationUpdateRequest $request) {
		$application = $request->getApplication();

		$application->loadRequest($request);

		$redirect = redirect()->action(ApplicationController::class . '@show', ['uuid' => $application->uuid]);

		if (false === $application->save()) {
			return $redirect->withErrors(['request-error-message' => 'Не удалось обновить данные']);
		}

		return $redirect->with('request-success-message', 'Приложение успешно обновлено');
	}

	/**
	 * Удаление приложения.
	 *
	 * @param string $uuid Идентификатор приложения
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function delete(string $uuid) {
		/** @var Application $application */
		$application = Application::find($uuid);

		$redirect = redirect()->action(ApplicationController::class . '@index');

		if ($application->owner_uuid !== Auth::user()->user_uuid) {
			return $redirect->withErrors(['request-error-message' => 'У вас нет прав на удаление данного приложения']);
		}

		if (false === $application->delete()) {
			return $redirect->withErrors(['request-error-message' => 'Не удалось удалить приложение']);
		}

		return $redirect->with('request-success-message', 'Приложение удалено');
	}
}