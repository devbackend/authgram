<?php

namespace App\Jobs;

use App\Exceptions\Handler;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramResponseException;

/**
 * Задание по отправке сообщения владельцу приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class SendMessageJob extends AbstractQueueJob {
	/** @var string */
	private $message;

	/**
	 * @param array $message Сообщение.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(array $message) {
		$this->message = $message;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle() {
		try {
			app(Api::class)->sendMessage($this->message);
		}
		catch (TelegramResponseException $e) {
			app(Handler::class)->report($e);
		}
	}
}