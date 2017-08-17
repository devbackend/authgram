<?php
namespace App\Console\Commands\Telegram;

use App\Entities\Application;
use App\Entities\AuthCommand;
use App\Entities\LogAuthAttempt;
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

		$cacheKey    = AuthCommand::getKeyName($this->name);
		$authCommand = $this->cache->get($cacheKey);/** @var AuthCommand $authCommand */

		$from = $this->getUpdate()->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		//-- Логируем попытку авторизации
		$authAttempt = LogAuthAttempt::create([
			LogAuthAttempt::STEP        => LogAuthAttempt::STEP_GET_COMMAND,
			LogAuthAttempt::USER_UUID   => $user->uuid,
			LogAuthAttempt::COMMAND     => $this->name,
		]);
		$authAttempt->save();
		//-- -- -- --

		if (null === $authCommand) {
			$replyMessage->setText('Команда не найдена');
			$this->replyWithMessage($replyMessage->get());

			event(new UserJoinFailEvent($this->name, 'Команда не найдена'));

			//-- Логируем попытку авторизации
			$additionalInfo = ['reason' => 'Команда не найдена'];

			$authAttempt = LogAuthAttempt::create([
				LogAuthAttempt::STEP            => LogAuthAttempt::STEP_AUTH_FAIL,
				LogAuthAttempt::USER_UUID       => $user->uuid,
				LogAuthAttempt::COMMAND         => $this->name,
				LogAuthAttempt::ADDITIONAL_INFO => json_encode($additionalInfo),
			]);
			$authAttempt->save();
			//-- -- -- --

			return;
		}

		$authKey = $this->generateAuthKey();
		$application = Application::find($authCommand->applicationUuid);

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
		$authRequest->token     = $application->api_token;
		$authRequest->authKey   = $authKey;
		$authRequest->user      = $authUser;

		for ($i = 0; $i < 3; $i++) {
			try {
				$response = $httpClient->post($application->auth_request_url, [
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

		$this->cache->forget($cacheKey);

		if (false === $isSuccessResponse) {
			$replyMessage->setText('Ошибка авторизации. Попробуйте позже');
			$this->replyWithMessage($replyMessage->get());

			event(new UserJoinFailEvent($this->name, 'Не смогли получить ответ от сайта'));

			//-- Логируем попытку авторизации
			$additionalInfo = ['reason' => 'Не смогли получить ответ от сайта'];

			$authAttempt = LogAuthAttempt::create([
				LogAuthAttempt::STEP                => LogAuthAttempt::STEP_AUTH_FAIL,
				LogAuthAttempt::USER_UUID           => $user->uuid,
				LogAuthAttempt::APPLICATION_UUID    => $authCommand->applicationUuid,
				LogAuthAttempt::COMMAND             => $this->name,
				LogAuthAttempt::ADDITIONAL_INFO     => json_encode($additionalInfo),
			]);
			$authAttempt->save();
			//-- -- -- --

			return;
		}

		event(new UserJoinSuccessEvent($this->name, $authKey));

		//-- Логируем попытку авторизации
		$authAttempt = LogAuthAttempt::create([
			LogAuthAttempt::STEP                => LogAuthAttempt::STEP_AUTH_SUCCESS,
			LogAuthAttempt::USER_UUID           => $user->uuid,
			LogAuthAttempt::APPLICATION_UUID    => $authCommand->applicationUuid,
			LogAuthAttempt::COMMAND             => $this->name,
		]);
		$authAttempt->save();
		//-- -- -- --

		$replyMessage->setText("Вы успешно авторизовались. \n\n Вернитесь в браузер, чтобы продолжить работу с сайтом.");

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