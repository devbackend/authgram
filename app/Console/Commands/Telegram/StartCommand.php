<?php

namespace App\Console\Commands\Telegram;

use App\Entities\User;

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
		$update = $this->getUpdate();
		$from   = $update->getMessage()->getFrom();

		$user = User::loadByTelegramProfile($from);

		if ('' !== $arguments) {
			$this->triggerCommand($arguments);

			return;
		}

		$message = $this->initiateMessage()
			->setText('Привет' . ('' !== $user->first_name ? ', ' . $user->first_name : '') . '!')
			->get()
		;

		$this->replyWithMessage($message);

		$this->triggerCommand(HelpCommand::class);
	}
}
