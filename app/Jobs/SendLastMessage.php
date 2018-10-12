<?php

namespace App\Jobs;

use App\Entities\User;
use App\Repositories\UserRepository;
use Monolog\Logger;
use Telegram\Bot\Api;
use Throwable;

/**
 * Отправка последего сообщения пользователю.
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class SendLastMessage extends AbstractQueueJob {
	/** @var string */
	private $userId;

	public function __construct(string $userId) {
		$this->userId = $userId;
	}

	public function handle() {
		$telegram = app(Api::class);/** @var Api $telegram */
		$user     = app(UserRepository::class)->get($this->userId);/** @var User $user */
		if (null === $user) {
			app(Logger::class)->error('Пользователь ' . $this->userId . ' не найден');

			return;
		}

		$user->last_message_attempts++;

		try {
			$telegram->sendMessage([
				'chat_id' => $user->telegram_id,
				'text'    => 'Это последнее сообщение',
			]);

			$user->last_message_status = true;
		}
		catch (Throwable $e) {
			$user->last_message_status = false;
		}

		$user->save();
	}
}
