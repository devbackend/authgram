<?php

namespace App\Http\Controllers\Dashboard;

use App;
use App\Entities\Application;
use App\Entities\Owner;
use App\Http\Controllers\Controller;
use Auth;
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
		$owner = Auth::user(); /** @var Owner $owner */

		$applications = $owner->user->applications;

		return $this->render('index', ['applications' => $applications]);
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
		$application = Application::where(Application::UUID, $uuid)->first();
		$owner = Auth::user(); /** @var Owner $owner */

		if (null === $application || $application->owner_uuid !== $owner->user->uuid) {
			App::abort(404);
		}

		return $this->render('view', ['application' => $application]);
	}
}
