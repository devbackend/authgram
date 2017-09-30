<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Контроллер логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogsController extends Controller {

	/**
	 * Список логов.
	 *
	 * @param LogRepository $repository
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function indexAction(LogRepository $repository) {
		return $this->render('index', ['logs' => $repository->load()]);
	}

	/**
	 * Просмотр лога.
	 *
	 * @param string        $guid
	 * @param LogRepository $repository
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function showAction(string $guid, LogRepository $repository) {
		$log = $repository->get($guid);
		if (null === $log) {
			abort(404);
		}

		return $this->render('show', ['log' => $log]);
	}

	/**
	 * @param Request       $request
	 * @param LogRepository $logs
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function deleteSelectedAction(Request $request, LogRepository $logs) {
		$guids = $request->input('guids');

		if ([] !== $guids) {
			$logs->deleteAll($guids);
		}

		return redirect()->action('Dashboard\LogsController@indexAction');
	}

	/**
	 * @param Request       $request
	 * @param LogRepository $logs
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function deleteContentAction(Request $request, LogRepository $logs) {
		$logContent = $request->input('log');

		if ('' !== $logContent) {
			$logs->deleteByContent($logContent);
		}

		return redirect()->action('Dashboard\LogsController@indexAction');
	}
}