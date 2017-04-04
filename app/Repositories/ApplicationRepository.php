<?php

namespace App\Repositories;

use App\Entities\Application;

/**
 * Репозиторий приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationRepository extends Repository {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new Application;
	}
}