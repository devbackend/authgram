<?php

namespace App\Repositories;

use App\Entities\LogIncomeMessage;

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class IncomeMessageRepository extends Repository {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new LogIncomeMessage;
	}
}