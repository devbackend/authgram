<?php

namespace App\Repositories;

use App\Entities\User;

/**
 * Репозиторий пользователей.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserRepository extends Repository {

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function get($id) {
		return $this->entity->where(User::UUID, $id)->first();
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new User();
	}
}