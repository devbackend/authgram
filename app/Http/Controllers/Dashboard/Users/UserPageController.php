<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *Контроллер страницы просмотра пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserPageController extends BackOfficeController {
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
	public function __invoke($uuid, UserRepository $userRepository) {
		$user = $userRepository->get($uuid);
		if (null === $user) {
			throw new NotFoundHttpException();
		}

		return $this->render('show', ['user' => $user]);
	}
}