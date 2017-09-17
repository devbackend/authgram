<?php

namespace App\Console\Commands\Telegram;

use App\Entities\Application;

/**
 * Добавление приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AddApplicationCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'add';

	/** @var string Описание команды */
	protected $description = 'Добавление приложения';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$update = $this->getUpdate();
		$from   = $update->getMessage()->getFrom();

		$user = $this->users->loadByTelegramProfile($from);

		$application = new Application;
		$application->owner_uuid = $user->uuid;
		$application->title      = $arguments;
		$application->website    = '';
		$application->save();

		$message = $this->initiateMessage()
			->setText("Ваше приложение успешно создано.\nТокен: " . $application->api_token)
			->get()
		;

		$this->replyWithMessage($message);
	}
}
