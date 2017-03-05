<?php
namespace App\Http\Controllers;

use App;
use App\Wrappers\JsonResponseWrapper;
use App\Wrappers\ReleaseLogs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер для работы с данными релизов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ReleasesController extends Controller {
	/**
	 * Получение информации по релизам.
	 *
	 * @param Request $request Входящий запрос
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getInfoAction(Request $request) {
		$callback = $request->get('callback');
		if (null === $callback) {
			App::abort(401);
		}

		$response = new JsonResponseWrapper();

		//-- Сканируем директорию с релизами
		$releaseList = scandir(base_path() . '/deploy/releases/');
		foreach ($releaseList as $release) {
			$releaseDir = base_path() . '/deploy/releases/' . $release;

			if ('.' === $release || '..' === $release || false === is_dir($releaseDir)) {
				continue;
			}

			$releaseLogs = new ReleaseLogs;
			$logs = scandir($releaseDir);
			foreach ($logs as $logFile) {
				if ('.' === $logFile || '..' === $logFile) {
					continue;
				}

				if ('.new' === $logFile) {
					$releaseLogs->status = ReleaseLogs::RELEASE_STATUS_NEW;

					continue;
				}

				if ('.process' === $logFile) {
					$releaseLogs->status = ReleaseLogs::RELEASE_STATUS_PROCESS;

					continue;
				}

				$logName = explode('.', $logFile);
				$logName = reset($logName);
				$releaseLogs->$logName = file_get_contents($releaseDir . '/' . $logFile);

				$response->data[$release] = $releaseLogs;
			}
		}
		//-- -- -- --

		krsort($response->data);

		//return response()->json($response);
		return response()->jsonp($callback, $response);
	}
}