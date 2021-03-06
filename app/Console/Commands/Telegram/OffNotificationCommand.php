<?php

namespace App\Console\Commands\Telegram;

/**
 * Команда для отключения уведомлений от бота для владельцев приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class OffNotificationCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'off';

	/** @var string Описание команды */
	protected $description = 'Отключение уведомлений от бота для владельцев приложений.';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$replyMessage = $this->initiateMessage();

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = $this->users->loadByTelegramProfile($from);
		$user->notification_enabled = false;
		$user->save();

		$replyMessage->setText(implode("\n\n", [
			'Вы отписаны от уведомлений бота',
			'Если снова захотите быть в курсе обновлений - отправьте боту команду /on',
		]));

		$this->replyWithMessage($replyMessage->get());
	}
}
