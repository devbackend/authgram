<?php

namespace App\Console\Commands;

use App\Entities\AuthCommand;
use App\Entities\LogAuthAttemptTmp;
use App\Entities\LogAuthStep;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

/**
 * Миграция записей со старой базы логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class MigrateOldLogs extends Command {
	protected $signature = 'move:old-logs';

	protected $description = 'Команда для переноса старых логов в новую таблицу';

	/**
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle() {
		/** @var Collection|LogAuthAttemptTmp[] $commands */
		$commands = (new LogAuthAttemptTmp())->newQuery()
			->where(LogAuthAttemptTmp::IS_MOVED, false)
			->orderBy(LogAuthAttemptTmp::INSERT_STAMP)
			->orderBy(LogAuthAttemptTmp::STEP)
			->get()
		;

		$guids      = [];
		$startTimes = [];

		foreach ($commands as $command) {
			if (false === array_key_exists($command->command, $guids) || LogAuthAttemptTmp::STEP_GET_CODE === $command->command) {
				$guids[$command->command] = Uuid::uuid4()->toString();
			}

			$attemptGuid = $guids[$command->command];

			$this->info('Обработка id = ' . $command->id);

			$logAuthStep                    = new LogAuthStep();
			$logAuthStep->guid              = Uuid::uuid4()->toString();
			$logAuthStep->attempt_guid      = $attemptGuid;
			$logAuthStep->insert_stamp      = $command->insert_stamp;
			$logAuthStep->application_uuid  = $command->application_uuid;
			$logAuthStep->command           = $command->command;
			$logAuthStep->user_uuid         = $command->user_uuid;
			$logAuthStep->message           = '';

			switch ($command->step) {
				case LogAuthAttemptTmp::STEP_GET_CODE:
					$logAuthStep->step = LogAuthStep::STEP_GET_CODE;

					$startTimes[$attemptGuid] = (new Carbon($command->insert_stamp))->timestamp;

					break;

				case LogAuthAttemptTmp::STEP_GET_COMMAND:
					$logAuthStep->step = LogAuthStep::STEP_GET_COMMAND;

					break;

				case LogAuthAttemptTmp::STEP_AUTH_SUCCESS:
					if (false === array_key_exists($attemptGuid, $startTimes)) {
						$this->error('Идентификатор ' . $command->id . ' является логом успешной авторизации, однако начало найти не удалось');

						continue(2);
					}

					$authTime = (new Carbon($command->insert_stamp))->timestamp;

					$logAuthStep->step    = LogAuthStep::STEP_AUTH_SUCCESS;
					$logAuthStep->message = 'Авторизация завершена за ' . ($authTime - $startTimes[$attemptGuid]) . 'c';

					unset($guids[$command->command]);

					break;

				case LogAuthAttemptTmp::STEP_AUTH_FAIL:
					if (true === array_key_exists($attemptGuid, $startTimes)) {
						$failTime =  (new Carbon($command->insert_stamp))->timestamp - $startTimes[$attemptGuid];
						$failTime -= AuthCommand::EXPIRED_TIME_SEC;

						$reason = 'Команда устарела на ' . $failTime . ' c';
					}
					else {
						$reason = json_decode($command->additional_info, true);
						$reason = end($reason);
					}

					$logAuthStep->step    = LogAuthStep::STEP_AUTH_FAIL;
					$logAuthStep->message = 'Причина: ' . $reason;

					unset($guids[$command->command]);

					break;
			}

			$logAuthStep->save();

			$command->is_moved = true;
			$command->save();
		}
	}
}
