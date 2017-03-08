<?php

namespace App\Console;

use App\Console\Commands\CreateTelegramCommand;
use App\Console\Commands\SetApplicationAuthCommand;
use App\Console\Commands\WebhookSwitchCommand;
use App\Entities\AuthCode;
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
		SetApplicationAuthCommand::class,
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
		//-- Очищаем неактивные коды
		$schedule->call(function () {
			$now = Carbon::now()->toDateTimeString();

			DB::table(AuthCode::table())->where(AuthCode::EXPIRED_AT, '<', $now)->delete();
		})->hourly();
		//-- -- -- --
	}
}
