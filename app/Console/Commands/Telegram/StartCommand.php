<?php

namespace App\Console\Commands\Telegram;

/**
 * Команда для инициализации работы с ботом.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class StartCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'start';

	/** @var string Описание команды */
	protected $description = 'Начало работы с ботом';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$message = $this->initiateMessage()
			->setText('Привет!')
			->get()
		;

		$this->replyWithMessage($message);
	}
}
