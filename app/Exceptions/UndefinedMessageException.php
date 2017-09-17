<?php

namespace App\Exceptions;

use Exception;
use Telegram\Bot\Objects\Update;

/**
 * Исключение при неудачной попытке определения сообщения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UndefinedMessageException extends Exception {
	/**
	 * @param Update $telegramUpdate
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(Update $telegramUpdate) {
		$message = addslashes(serialize($telegramUpdate));

		parent::__construct($message);
	}
}