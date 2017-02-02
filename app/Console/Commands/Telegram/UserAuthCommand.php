<?php

namespace App\Console\Commands\Telegram;

use App\Entities\AuthCode;
use App\Entities\User;
use App\Events\UserJoined;

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserAuthCommand extends TelegramCommand {
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
		$code = (int)$arguments;
		$authCode = AuthCode::check($code);

		$replyMessage = $this->initiateMessage();

		if (null === $authCode) {
			$replyMessage->setText('Код авторизации не найден');
			$this->replyWithMessage($replyMessage->get());

			return;
		}

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		event(new UserJoined($user));

		$replyMessage->setText('Вы успешно авторизовались');

		$this->replyWithMessage($replyMessage->get());
	}
}
