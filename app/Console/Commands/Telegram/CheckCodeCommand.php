<?php

namespace App\Console\Commands\Telegram;

use App\Entities\AuthCode;
use App\Entities\User;
use App\Events\CodeChecked;
use GuzzleHttp\Client;

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

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		//-- Отправляем запрс с авторизационными данными приложению
		$client = new Client;
		// Пытаем отправить запрос в несколько попыток
		$isSuccessResponse = false;
		for ($i = 0; $i < 3; $i++) {
			$response = $client->post($authCode->application->auth_request_url, [
				'form_params' => [
					'token'         => $authCode->application->api_token,
					'uuid'          => $user->uuid,
					'username'      => $user->username,
					'first_name'    => $user->first_name,
					'last_name'     => $user->last_name,
				]
			]);

			if (200 === $response->getStatusCode()) {
				$isSuccessResponse = true;

				break;
			}
		}
		//-- -- -- --

		if (false === $isSuccessResponse) {
			$replyMessage->setText('Ошибка авторизации. Попробуйте позже');
			$this->replyWithMessage($replyMessage->get());

			event(new CodeChecked(false, ''));

			return;
		}

		event(new CodeChecked(true, $authCode->application->redirect_url . '?user_uuid=' . $user->uuid));

		$replyMessage->setText('Вы успешно авторизовались');

		$this->replyWithMessage($replyMessage->get());
	}
}
