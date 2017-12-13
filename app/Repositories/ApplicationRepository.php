<?php

namespace App\Repositories;

use App\Entities\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Репозиторий приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationRepository extends Repository {
	/**
	 * Получение приложений, разбитых постарничной навигацией.
	 *
	 * @return LengthAwarePaginator|Application[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getPaginatedApplications() {
		$applications = $this->entity->newQuery()
			->orderByDesc(Application::CREATED_AT)
			->paginate(50)
		;

		return $applications;
	}

	/**
	 * Получение идентификаторов владельцев приложений.
	 *
	 * @return string[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getApplicationOwnerIds(): array {
		$guids = $this->entity->newQuery()
			->select(Application::OWNER_UUID)
			->distinct()
			->get()
		;/** @var Application[] $guids */

		$result = [];
		foreach ($guids as $guid) {
			$result[] = $guid->owner_uuid;
		}

		return $result;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new Application;
	}
}