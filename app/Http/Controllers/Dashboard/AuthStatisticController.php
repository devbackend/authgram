<?php

namespace App\Http\Controllers\Dashboard;

use App\Entities\LogAuthAttemptTmp;
use App\Http\Controllers\Controller;
use Illuminate\Database\Connection;
use Illuminate\View\View;

/**
 * Контроллер для просмотра статистика авторизаций при помощи бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthStatisticController extends Controller {
	/** Лимит записей на страницу */
	const MESSAGE_PAGE_LIMIT = 50;

	/**
	 * Главная страница.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 *
	 * @param Connection $db
	 *
	 * @return View
	 */
	public function indexAction(Connection $db) {
		$attempts = (new LogAuthAttemptTmp())
			->select([
				'*',
				$db->raw("date_trunc('minutes', insert_stamp) as stamp")
			])
			->orderBy('stamp',                  'desc')
			->orderBy(LogAuthAttemptTmp::COMMAND,  'asc')
			->orderBy(LogAuthAttemptTmp::STEP,     'asc')
			->paginate(self::MESSAGE_PAGE_LIMIT)
		;

		return $this->render('index', ['attempts' => $attempts]);
	}
}