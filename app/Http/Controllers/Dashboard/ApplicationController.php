<?php

namespace App\Http\Controllers\Dashboard;

use App;
use App\Entities\Application;
use App\Entities\Policy;
use App\Http\Controllers\Controller;
use App\Http\Requests\application\ApplicationUpdateRequest;
use Auth;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Контроллер для работы с приложениями в панели управления.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationController extends Controller {
	/**
	 * Входная точка управления приложениями.
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function index() {
		if (true === Gate::allows(Policy::ADMIN_ACTION)) {
			$applications = Application::orderBy(Application::DELETED_AT, SORT_DESC)->orderBy(Application::CREATED_AT, SORT_DESC)->withTrashed();
		}
		else {
			$applications = Application::orderBy(Application::CREATED_AT, SORT_DESC)->where(Application::OWNER_UUID, Auth::user()->user_uuid);
		}

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
			App::abort(404);
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

		$redirect = redirect()->action('Dashboard\ApplicationController@show', ['uuid' => $application->uuid]);

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

		$redirect = redirect()->action('Dashboard\ApplicationController@index');

		if ($application->owner_uuid !== Auth::user()->user_uuid) {
			return $redirect->withErrors(['request-error-message' => 'У вас нет прав на удаление данного приложения']);
		}

		if (false === $application->delete()) {
			return $redirect->withErrors(['request-error-message' => 'Не удалось удалить приложение']);
		}

		return $redirect->with('request-success-message', 'Приложение удалено');
	}
}
