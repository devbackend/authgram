<?php

namespace App\Repositories;

use App\Entities\AuthCommand;
use App\Entities\LogAuthStep;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

/**
 * Репозиторий логов шагов авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogAuthStepRepository extends Repository {

	/**
	 * Логирование получени кода.
	 *
	 * @param AuthCommand $authCommand
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function writeCodeStep(AuthCommand $authCommand) {
		$logAuthStep                = new LogAuthStep();
		$logAuthStep->guid          = Uuid::uuid4()->toString();
		$logAuthStep->insert_stamp  = Carbon::now();

		$logAuthStep->attempt_guid      = $authCommand->attemptGuid;
		$logAuthStep->application_uuid  = $authCommand->applicationUuid;
		$logAuthStep->command           = $authCommand->command;
		$logAuthStep->user_uuid         = Uuid::NIL;
		$logAuthStep->step              = LogAuthStep::STEP_GET_CODE;
		$logAuthStep->message           = '';

		$logAuthStep->save();
	}

	/**
	 * Логирование шага получения команды.
	 *
	 * @param AuthCommand $authCommand
	 * @param string      $userGuid
	 *
	 * @author   Кривонос Иван <devbackend@yandex.ru>
	 */
	public function writeCommandStep(AuthCommand $authCommand, string $userGuid) {
		$logAuthStep                = new LogAuthStep();
		$logAuthStep->guid          = Uuid::uuid4()->toString();
		$logAuthStep->insert_stamp  = Carbon::now();

		$logAuthStep->attempt_guid      = $authCommand->attemptGuid;
		$logAuthStep->application_uuid  = $authCommand->applicationUuid;
		$logAuthStep->command           = $authCommand->command;
		$logAuthStep->user_uuid         = $userGuid;
		$logAuthStep->step              = LogAuthStep::STEP_GET_COMMAND;
		$logAuthStep->message           = '';

		$logAuthStep->save();
	}

	/**
	 * @param AuthCommand $authCommand
	 * @param string      $userGuid
	 * @param string      $reason
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function writeFailResultStep(AuthCommand $authCommand, string $userGuid, string $reason) {
		$logAuthStep                = new LogAuthStep();
		$logAuthStep->guid          = Uuid::uuid4()->toString();
		$logAuthStep->insert_stamp  = Carbon::now();

		$logAuthStep->attempt_guid      = $authCommand->attemptGuid;
		$logAuthStep->application_uuid  = $authCommand->applicationUuid;
		$logAuthStep->command           = $authCommand->command;
		$logAuthStep->user_uuid         = $userGuid;
		$logAuthStep->step              = LogAuthStep::STEP_AUTH_FAIL;
		$logAuthStep->message           = 'Причина: ' . $reason;

		$logAuthStep->save();
	}

	/**
	 * @param AuthCommand   $authCommand
	 * @param string        $userGuid
	 * @param string[]      $logs
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function writeSuccessResultStep(AuthCommand $authCommand, string $userGuid, array $logs) {
		$logAuthStep                = new LogAuthStep();
		$logAuthStep->guid          = Uuid::uuid4()->toString();
		$logAuthStep->insert_stamp  = Carbon::now();

		$logAuthStep->attempt_guid      = $authCommand->attemptGuid;
		$logAuthStep->application_uuid  = $authCommand->applicationUuid;
		$logAuthStep->command           = $authCommand->command;
		$logAuthStep->user_uuid         = $userGuid;
		$logAuthStep->step              = LogAuthStep::STEP_AUTH_SUCCESS;
		$logAuthStep->message           = implode(', ', $logs);

		$logAuthStep->save();
	}

	/**
	 * Получение идентификаторов последних попыток авторизации.
	 *
	 * @param int $limit Количество попыток.
	 *
	 * @return LogAuthStep[]|LengthAwarePaginator
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getLastAttempts(int $limit) {
		$lastAttempts = $this->initEntity()->newQuery()
			->select([
				LogAuthStep::ATTEMPT_GUID,
				$this->db->raw('min(' . LogAuthStep::INSERT_STAMP . ') AS ' . LogAuthStep::INSERT_STAMP)
			])
			->groupBy([LogAuthStep::ATTEMPT_GUID])
			->orderByDesc(LogAuthStep::INSERT_STAMP)
			->paginate($limit)
		;

		return $lastAttempts;
	}

	/**
	 * Получение логов шагов авторизации.
	 *
	 * @param string[] $attemptIds
	 *
	 * @return LogAuthStep[][]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getAuthStepsByAttemptIds(array $attemptIds) {
		/** @var Collection|LogAuthStep[] $authSteps */
		$authSteps = $this->initEntity()->newQuery()
			->whereIn(LogAuthStep::ATTEMPT_GUID, $attemptIds)
			->orderBy(LogAuthStep::STEP)
			->get()
		;

		$result = [];
		foreach ($authSteps as $authStep) {
			if (false === array_key_exists($authStep->attempt_guid, $result)) {
				$result[$authStep->attempt_guid] = [];
			}

			$result[$authStep->attempt_guid][$authStep->step] = $authStep;
		}

		return $result;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		return new LogAuthStep();
	}
}