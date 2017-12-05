<?php

namespace App\Http\Controllers\Dashboard\IncomeMessages;

use App\Entities\LogIncomeMessage;
use App\Http\Controllers\BackOfficeController;
use Illuminate\Contracts\View\View;

/**
 * Контроллер списка сообщений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class IncomeMessagesController extends BackOfficeController {
	/** Лимит сообщений на страницу */
	const MESSAGE_PAGE_LIMIT = 25;

	/**
	 * Главная страница контроллера
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		$messages = (new LogIncomeMessage)
			->orderBy(LogIncomeMessage::CREATED_AT, SORT_DESC)
			->paginate(static::MESSAGE_PAGE_LIMIT)
		;

		return $this->render('index', ['messages' => $messages]);
	}
}