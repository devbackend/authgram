<?php

namespace App\Console\Commands\Telegram;

use App\Wrappers\TelegramMessage;
use Telegram\Bot\Commands\Command;

/**
 * Базовый класс команд Telegram бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class TelegramCommand extends Command {
	/**
	 * Инициализация сообщения
	 *
	 * @return TelegramMessage
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initiateMessage() {
		return new TelegramMessage;
	}
}