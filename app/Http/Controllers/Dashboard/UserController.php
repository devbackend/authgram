<?php

namespace App\Http\Controllers\Dashboard;

use App;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\View\View;

/**
 * Контроллер для работы с пользователями
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserController extends Controller {
	/** Лимит пользователей на страницу */
	const MESSAGE_PAGE_LIMIT = 25;

	/**
	 * Главная страница контроллера
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function indexAction() {
		$users = (new User)
			->orderBy(User::CREATED_AT, SORT_DESC)
			->paginate(self::MESSAGE_PAGE_LIMIT)
		;

		return $this->render('index', ['users' => $users]);
	}

	/**
	 * Страница пользователя
	 *
	 * @param string         $uuid              Идентификатор пользователя
	 * @param UserRepository $userRepository    Репозиторий пользователей
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function showAction($uuid, UserRepository $userRepository) {
		$user = $userRepository->get($uuid);
		if (null === $user) {
			App::abort(404);
		}

		return $this->render('show', ['user' => $user]);
	}
}