<?php

namespace App\Console;

use App\Console\Commands\CreateTelegramCommand;
use App\Console\Commands\WebhookSwitchCommand;
use App\Entities\LogIncomeMessage;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Connection;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Ядро для работы консольной части приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Kernel extends ConsoleKernel {
	/** @var string[] Консольные команды */
	protected $commands = [
		CreateTelegramCommand::class,
		WebhookSwitchCommand::class,
	];

	/**
	 * Команды, выполняемые по расписанию.
	 *
	 * @param Schedule $schedule Расписание
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function schedule(Schedule $schedule) {
		$schedule->call(function() {
			$minimalLogDate = date('c', time() - 50 * 86400);

			/** @var Connection $db */
			$db = resolve(Connection::class);

			$db->beginTransaction();

			try {
				$db->table('log_income_messages')->where(LogIncomeMessage::CREATED_AT, '<', $minimalLogDate)->delete();
				$db->table('log_auth_attempts')->where(LogIncomeMessage::CREATED_AT, '<', $minimalLogDate)->delete();

				$db->commit();
			} catch (Exception $e) {
				$db->rollBack();
			}
		})->daily();
	}
}
