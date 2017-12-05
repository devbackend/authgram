<?php

namespace App\Http\Controllers\Dashboard\Logs;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\LogRepository;
use Illuminate\Contracts\View\View;

/**
 * Контроллер страницы логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ShowLogController extends BackOfficeController {
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
	public function __invoke(string $guid, LogRepository $repository) {
		$log = $repository->get($guid);
		if (null === $log) {
			abort(404);
		}

		return $this->render('show', ['log' => $log]);
	}
}