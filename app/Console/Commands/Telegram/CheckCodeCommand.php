<?php

namespace App\Console\Commands\Telegram;

/**
 * Проверка кода авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CheckCodeCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'i';

	/** @var string Описание команды */
	protected $description = 'Авторизация пользователя';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$replyMessage = $this->initiateMessage()
			->setText(
				implode(' ', [
					'Данная команда больше не используется для авторизации:',
					'теперь авторизоваться вы можете с помощью команды авторизации.',
					'Для её получения нажмите кнопку "Войти через Telegram" на сайте,',
					'где хотите совершить вход.'
				])
			)
			->get()
		;

		$this->replyWithMessage($replyMessage);
	}
}
