<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Entities\User;
use App\Http\Controllers\BackOfficeController;
use Illuminate\Contracts\View\View;

/**
 * Контроллер списка пользователей.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UsersListController extends BackOfficeController {
	/** Лимит пользователей на страницу */
	const MESSAGE_PAGE_LIMIT = 25;

	/**
	 * Главная страница контроллера
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		$users = (new User)
			->orderBy(User::CREATED_AT, SORT_DESC)
			->paginate(self::MESSAGE_PAGE_LIMIT)
		;

		return $this->render('index', ['users' => $users]);
	}

}