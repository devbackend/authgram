<?php

namespace App\Repositories;

use App\Entities\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Репозиторий логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogRepository extends Repository {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new Log();
	}

	/**
	 * Загрузка логов.
	 *
	 * @return LengthAwarePaginator
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function load() {
		return $this->entity
			->where('deleted_at', null)
			->orderBy(Log::INSERT_STAMP, 'desc')
			->paginate(50)
		;
	}
}