<?php

namespace App\Console\Commands\Telegram;

use App\Entities\LogIncomeMessage;
use App\Entities\User;
use App\Repositories\DashboardStatisticRepository;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Команда для быстрой проверки жизни бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class YoCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'yo';

	/** @var string Описание команды */
	protected $description = 'Быстрая проверка жизни бота.';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$update = $this->getUpdate();
		$from   = $update->getMessage()->getFrom();

		$user = $this->users->loadByTelegramProfile($from);

		$message = $this->initiateMessage();

		if (User::ADMIN_TELEGRAM_ID !== $user->telegram_id) {
			try {
				$message->setText('Команда не найдена');
				$this->replyWithMessage($message->get());
			}
			catch(TelegramSDKException $e) {
				$this->logger->error('Не удалось отправить собщению пользователю: ' . $e->getMessage());
			}

			return;
		}

		/** @var DashboardStatisticRepository $statistic */
		$statistic = resolve(DashboardStatisticRepository::class);

		$message->setText(implode("\n", [
			'За последний час:',
			'Количество новых пользователей: ' . $statistic->getEntityCount(User::class, 1),
			'Количество новых сообщений: ' . $statistic->getEntityCount(LogIncomeMessage::class, 1),
		]));

		$this->replyWithMessage($message->get());
	}
}
