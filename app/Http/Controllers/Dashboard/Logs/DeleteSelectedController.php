<?php

namespace App\Http\Controllers\Dashboard\Logs;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\LogRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Контроллер удаления выбранных логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DeleteSelectedController extends BackOfficeController {
	/**
	 * @param Request       $request
	 * @param LogRepository $logs
	 *
	 * @return RedirectResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request, LogRepository $logs) {
		$guids = $request->input('guids');

		if ([] !== $guids) {
			$logs->deleteAll($guids);
		}

		return redirect()->action(LogsListController::class);
	}

}