<?php

namespace App\Repositories;

use App\Entities\Entity;
use App\Exceptions\NotImplementedException;

/**
 * Репозиторий для статистики приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DashboardStatisticRepository extends Repository {
	/**
	 * Получение количества записей.
	 *
	 * @param string $entity
	 *
	 * @return int
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getEntityTotalCount(string $entity): int {
		$cacheKey = $this->getCacheKey(__METHOD__, [$entity]);
		$count    = $this->cache->get($cacheKey);

		if (null === $count) {
			/** @var Entity $entity */
			$entity = new $entity;

			$count = $entity->count();

			$this->cache->put($cacheKey, $count, 60);
		}

		return $count;
	}

	/**
	 * Получение количества записей за последнеи несколько часов
	 *
	 * @param string $entity    Модель
	 * @param int    $hours     Количество часов для выборки
	 *
	 * @return int
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getCountByHourPeriod(string $entity, $hours = 24): int {
		$cacheKey   = $this->getCacheKey(__METHOD__, [$entity, $hours]);
		$count      = $this->cache->get($cacheKey);
		if (null === $count) {
			/** @var Entity $entity */
			$entity = new $entity;

			$date = date('c', time() - $hours * 3600);

			$count = $entity->where($entity::CREATED_AT, '>=', $date)->count();

			$this->cache->put($cacheKey, $count, 60);
		}

		return $count;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function get($id) {
		throw new NotImplementedException(__METHOD__);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getLastRecords(int $count = 10) {
		throw new NotImplementedException(__METHOD__);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getEntity(): Entity {
		throw new NotImplementedException(__METHOD__);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {}
}