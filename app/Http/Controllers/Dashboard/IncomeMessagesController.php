<?php
namespace App\Http\Controllers\Dashboard;

use App\Entities\LogIncomeMessage;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Контроллер для обработки входящих сообщений к боту.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class IncomeMessagesController extends Controller {
	/** Лимит сообщений на страницу */
	const MESSAGE_PAGE_LIMIT = 25;

	/**
	 * Главная страница контроллера
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function indexAction() {
		$messages = (new LogIncomeMessage)
			->orderBy(LogIncomeMessage::CREATED_AT, SORT_DESC)
			->paginate(self::MESSAGE_PAGE_LIMIT)
		;

		return $this->render('index', ['messages' => $messages]);
	}
}