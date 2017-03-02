<?php

namespace App\Console\Commands\Telegram;

use App\Entities\AuthCode;
use App\Entities\User;
use App\Events\CodeChecked;
use App\Wrappers\authRequest\Request;
use App\Wrappers\authRequest\User as AuthUser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Log;

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

			event(new CodeChecked($code, false, ''));

			return;
		}

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		$authKey = md5(random_bytes(128));

		//-- Отправляем запрс с авторизационными данными приложению
		$client = new Client;
		// Пытаем отправить запрос в несколько попыток
		$isSuccessResponse = false;

		$authUser = new AuthUser;
		$authUser->uuid        = $user->uuid;
		$authUser->username     = $user->username;
		$authUser->firstName    = $user->first_name;
		$authUser->lastName    = $user->last_name;

		$authRequest = new Request;
		$authRequest->token     = $authCode->application->api_token;
		$authRequest->authKey   = $authKey;
		$authRequest->user      = $authUser;

		for ($i = 0; $i < 3; $i++) {
			try {
				$response = $client->post($authCode->application->auth_request_url, [
					'json' => $authRequest
				]);

				if (200 === $response->getStatusCode()) {
					$isSuccessResponse = true;

					break;
				}
			}
			catch (ServerException $e) {
				Log::error($e->getMessage());
			}
		}
		//-- -- -- --

		if (false === $isSuccessResponse) {
			$replyMessage->setText('Ошибка авторизации. Попробуйте позже');
			$this->replyWithMessage($replyMessage->get());

			event(new CodeChecked($code, false, ''));

			return;
		}

		event(new CodeChecked($code, true, $authKey));

		$replyMessage->setText('Вы успешно авторизовались');

		$this->replyWithMessage($replyMessage->get());

		$authCode->delete();
	}
}
