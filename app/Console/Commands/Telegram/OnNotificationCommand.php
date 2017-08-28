<?php

namespace App\Console\Commands\Telegram;

use App\Entities\User;

/**
 * Команда для включения уведомлений от бота для владельцев приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class OnNotificationCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'on';

	/** @var string Описание команды */
	protected $description = 'Включение уведомлений от бота для владельцев приложений.';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$replyMessage = $this->initiateMessage();

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);
		$user->notification_enabled = true;
		$user->save();

		$replyMessage->setText(implode("\n\n", [
			'Вы подписаны на уведомления от бота'
		]));

		$this->replyWithMessage($replyMessage->get());
	}
}
