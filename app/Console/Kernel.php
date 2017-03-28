<?php

namespace App\Console;

use App\Console\Commands\CreateTelegramCommand;
use App\Console\Commands\WebhookSwitchCommand;
use App\Entities\LogAuthAttempt;
use Carbon\Carbon;
use DB;
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
	];

	/**
	 * Команды, выполняемые по расписанию.
	 *
	 * @param Schedule $schedule Расписание
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function schedule(Schedule $schedule) {
		//-- Очищаем логи попыток авторизации старше двух недель
		$schedule->call(function () {
			$twoWeeksAgo = Carbon::now()->addWeek(-2)->toDateTimeString();

			DB::table(LogAuthAttempt::table())->where(LogAuthAttempt::INSERT_STAMP, '<', $twoWeeksAgo)->delete();
		})->weekly();
		//-- -- -- --
	}
}
