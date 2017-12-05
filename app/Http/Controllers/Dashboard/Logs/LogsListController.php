<?php

namespace App\Http\Controllers\Dashboard\Logs;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\LogRepository;
use Illuminate\Contracts\View\View;

/**
 * Контроллер списка логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogsListController extends BackOfficeController {
	/**
	 * @param LogRepository $repository
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(LogRepository $repository) {
		return $this->render('index', ['logs' => $repository->load()]);
	}
}