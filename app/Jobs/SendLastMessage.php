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
				'text'    => implode("\n", [
					'Привет!',
					"\n",
					'Мы с новостями! К сожалению не очень хорошими.',
					'Проект AuthGram развивался без малого два года. За это время мы многого достигли благодаря вам: подключили более 100 приложений, авторизовали 50 с небольшим тысяч человек. Обработали 150 000 сообщений, получили миллион запросов на авторизацию.',
					'Но к сожалению, в последнее время, наш проект развивается не такими темпами, как бы этого хотелось - здесь повлияли и недавние действия, связанные с блокировкой Telegram, и отсутствие свободного времени у команды на поддержку и развитие проекта.'
				]),
			]);

			$user->last_message_status = true;
		}
		catch (Throwable $e) {
			$user->last_message_status = false;
		}

		$user->save();
	}
}
