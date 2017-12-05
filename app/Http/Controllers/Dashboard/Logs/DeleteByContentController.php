<?php

namespace App\Http\Controllers\Dashboard\Logs;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\LogRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Контроллер удаления лога по содержимому.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DeleteByContentController extends BackOfficeController {
	/**
	 * @param Request       $request
	 * @param LogRepository $logs
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request, LogRepository $logs) {
		$logContent = $request->input('log');

		if ('' !== $logContent) {
			$logs->deleteByContent($logContent);
		}

		return redirect()->action(LogsListController::class);
	}
}