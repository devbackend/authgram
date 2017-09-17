<?php

namespace App\Repositories;

use App\Entities\Entity;
use App\Entities\LogAuthAttempt;
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
	 * @param string $entity    Модель
	 * @param int    $hours     Количество часов для выборки
	 *
	 * @return int
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getEntityCount(string $entity, $hours = 0): int {
		$cacheKey = $this->getCacheKey(__METHOD__, [$entity, $hours]);
		$count    = $this->cache->get($cacheKey);

		if (null === $count) {
			/** @var Entity $entity */
			$entity = new $entity;

			if ($hours > 0) {
				$date = date('c', time() - $hours * 3600);

				$entity = $entity->where($entity::CREATED_AT, '>=', $date);
			}

			$count = $entity->count();

			$this->cache->put($cacheKey, $count, 15);
		}

		return $count;
	}

	/**
	 * Получение статистики шагов авторизации.
	 *
	 * @param int|null $hours Количество часов статистики; по умолчанию весь период
	 *
	 * @return int[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getAuthStepsStatistic(int $hours = 0) {
		$cacheKey   = $this->getCacheKey(__METHOD__, [$hours]);
		$result     = $this->cache->get($cacheKey);
		if (null === $result) {
			$query = (new LogAuthAttempt())
				->select([
					LogAuthAttempt::STEP,
					$this->db->raw('count(id) as count')
				])
				->groupBy(LogAuthAttempt::STEP)
				->orderBy(LogAuthAttempt::STEP, 'ASC')
			;

			if ($hours > 0) {
				$date = date('c', time() - $hours * 3600);

				$query->where(LogAuthAttempt::INSERT_STAMP, '>=', $date)->count();
			}

			$attempts = $query->get()->toArray();

			$result = [];
			foreach ($attempts as $attempt) {
				$result[$attempt['step']] = $attempt['count'];
			}

			$this->cache->put($cacheKey, $result, 5);
		}

		return $result;
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