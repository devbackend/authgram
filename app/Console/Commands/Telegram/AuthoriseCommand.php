<?php
namespace App\Console\Commands\Telegram;

use App\Entities\AuthCommand;
use App\Entities\User;
use App\Events\UserJoinFailEvent;
use App\Events\UserJoinSuccessEvent;
use App\Wrappers\authRequest\Request;
use App\Wrappers\authRequest\User as AuthUser;
use Exception;
use GuzzleHttp\Client;

/**
 * Базовый класс команд авторизации. Здесь находится вся логика авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthoriseCommand extends TelegramCommand {
	/** @var string Описание команды */
	protected $description = 'Базовый класс команд авторизации. Здесь находится вся логика авторизации';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$replyMessage = $this->initiateMessage();

		$dbAuthCommand = AuthCommand::check($this->name);
		if (null === $dbAuthCommand) {
			$replyMessage->setText('Команда не найдена');
			$this->replyWithMessage($replyMessage->get());

			event(new UserJoinFailEvent($this->name, 'Команда не найдена'));

			return;
		}

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		$authKey = $this->generateAuthKey();

		//-- Отправляем запрс с авторизационными данными приложению
		$httpClient = new Client;
		// Пытаем отправить запрос в несколько попыток
		$isSuccessResponse = false;

		$authUser = new AuthUser;
		$authUser->uuid         = $user->uuid;
		$authUser->username     = $user->username;
		$authUser->firstName    = $user->first_name;
		$authUser->lastName     = $user->last_name;

		$authRequest = new Request;
		$authRequest->token     = $dbAuthCommand->application->api_token;
		$authRequest->authKey   = $authKey;
		$authRequest->user      = $authUser;

		for ($i = 0; $i < 3; $i++) {
			try {
				$response = $httpClient->post($dbAuthCommand->application->auth_request_url, [
					'json' => $authRequest
				]);

				if (200 === $response->getStatusCode()) {
					$isSuccessResponse = true;

					break;
				}
			}
			catch (Exception $e) {
				$this->logger->error($e->getMessage());
			}
		}
		//-- -- -- --

		$dbAuthCommand->delete();

		if (false === $isSuccessResponse) {
			$replyMessage->setText('Ошибка авторизации. Попробуйте позже');
			$this->replyWithMessage($replyMessage->get());

			event(new UserJoinFailEvent($this->name, 'Не смогли получить ответ от сайта'));

			return;
		}

		event(new UserJoinSuccessEvent($this->name, $authKey));

		$replyMessage->setText('Вы успешно авторизовались');

		$this->replyWithMessage($replyMessage->get());
	}

	/**
	 * Генерация авторизационного ключа.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function generateAuthKey() {
		return md5(random_bytes(128));
	}
}