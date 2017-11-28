<?php

namespace App\Console;

use App\Console\Commands\CreateTelegramCommand;
use App\Console\Commands\MigrateOldLogs;
use App\Console\Commands\WebhookSwitchCommand;
use Illuminate\Console\Scheduling\Schedule;
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
		MigrateOldLogs::class,
	];

	/**
	 * Команды, выполняемые по расписанию.
	 *
	 * @param Schedule $schedule Расписание
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function schedule(Schedule $schedule) {}
}
