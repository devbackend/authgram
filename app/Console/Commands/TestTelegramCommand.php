<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Команда для тестирования бота
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class TestTelegramCommand extends Command {
	/** @var string Команда */
	protected $signature = 'tgrm:test';

	/** @var string Описание комманды */
	protected $description = 'Command description';

	/**
	 * Запуск
	 */
	public function handle() {

	}
}
