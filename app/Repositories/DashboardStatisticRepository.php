<?php

namespace App\Repositories;

use App\Entities\Charts\BarChart;
use App\Entities\Charts\BarChartDataSet;
use App\Entities\Entity;
use App\Entities\LogAuthStep;
use App\Entities\LogIncomeMessage;
use App\Entities\User;
use App\Exceptions\NotImplementedException;
use Carbon\Carbon;

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
		$cacheKey   = $this->getCacheKey(__METHOD__, [$hours], 2);
		$result     = $this->cache->get($cacheKey);
		if (null === $result) {
			$query = (new LogAuthStep())
				->select([
					LogAuthStep::STEP,
					$this->db->raw('count(guid) as count')
				])
				->groupBy(LogAuthStep::STEP)
				->orderBy(LogAuthStep::STEP, 'ASC')
			;

			if ($hours > 0) {
				$date = date('c', time() - $hours * 3600);

				$query->where(LogAuthStep::INSERT_STAMP, '>=', $date)->count();
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
	 * Получение графика.
	 *
	 * @return BarChart
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getUsersAndMessagesChart(): BarChart {
		$chart = new BarChart();
		for ($i = -21; $i <= 0; $i += 3) {
			$date = Carbon::now()->addHours($i);

			$format = 'H:00';
			if (false === $date->isToday()) {
				$format = 'd.m H:00';
			}

			$chart->labels[] = $date->format($format);
		}

		// -- Формируем данные для пользователей
		$users = (new User())->newQuery()
			->select([
				$this->db->raw('count(uuid)'),
				$this->db->raw('trunc(EXTRACT(HOUR from created_at) / 3) as hours')
			])
			->whereRaw(User::CREATED_AT . '>= now() - INTERVAL \'24 hours\'')
			->groupBy('hours')
			->orderBy('hours')
			->get()
			->toArray()
		;

		$usersSet                  = new BarChartDataSet();
		$usersSet->label           = 'Пользователи';
		$usersSet->backgroundColor = '#004d40';

		foreach ($users as $userCount) {
			$usersSet->data[] = $userCount['count'];
		}

		$chart->datasets[] = $usersSet;
		// -- -- -- -- --

		// -- Формируем данные для сообщений
		$messages = (new LogIncomeMessage())->newQuery()
			->select([
				$this->db->raw('count(id)'),
				$this->db->raw('trunc(EXTRACT(HOUR from created_at) / 3) as hours')
			])
			->whereRaw(LogIncomeMessage::CREATED_AT . '>= now() - INTERVAL \'24 hours\'')
			->groupBy('hours')
			->orderBy('hours')
			->get()
			->toArray()
		;

		$messagesSet                  = new BarChartDataSet();
		$messagesSet->label           = 'Сообщения';
		$messagesSet->backgroundColor = '#0d47a1';

		foreach ($messages as $messageCount) {
			$messagesSet->data[] = $messageCount['count'];
		}

		$chart->datasets[] = $messagesSet;
		// -- -- -- -- --

		return $chart;
	}

	/**
	 * @return array
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getAuthStatisticChart() {
		$authSteps = (new LogAuthStep())->newQuery()
			->select([
				$this->db->raw('date_trunc(\'day\', insert_stamp)::date AS date'),
				LogAuthStep::STEP,
				$this->db->raw('count(guid) as count')
			])
			->whereRaw(LogAuthStep::INSERT_STAMP . ' >= now() - INTERVAL \'7 days\'')
			->groupBy('date', 'step')
			->orderBy('date')
			->orderBy(LogAuthStep::STEP)
			->get()
			->toArray()
		;

		$result = [];
		foreach ($authSteps as $authStep) {
			$date  = $authStep['date'];
			$step  = $authStep['step'];
			$count = $authStep['count'];

			if (false === array_key_exists($date, $result)) {
				$result[$date] = [
					'period'                        => $date,
					LogAuthStep::STEP_GET_CODE      => 0,
					LogAuthStep::STEP_GET_COMMAND   => 0,
					LogAuthStep::STEP_AUTH_FAIL     => 0,
					LogAuthStep::STEP_AUTH_SUCCESS  => 0,
				];
			}

			$result[$date][$step] = $count;
		}

		return array_values($result);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {}
}