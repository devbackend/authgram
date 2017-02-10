<?php

namespace App\Console\Commands\Telegram;

use App\Entities\AuthCode;
use App\Entities\User;
use App\Events\CodeChecked;

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
		$code = (int)$arguments;
		$authCode = AuthCode::check($code);

		$replyMessage = $this->initiateMessage();

		if (null === $authCode) {
			$replyMessage->setText('Код авторизации не найден');
			$this->replyWithMessage($replyMessage->get());

			event(new CodeChecked(false, ''));

			return;
		}

		//@todo-10.02.2017-krivonos.iv реализовать отправку данных пользователя в приложение и только потом отправлять перенаправление
		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		event(new CodeChecked(true, $authCode->application->redirect_url . '?user_uuid=' . $user->uuid));

		$replyMessage->setText('Вы успешно авторизовались');

		$this->replyWithMessage($replyMessage->get());
	}
}
