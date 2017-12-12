<?php
namespace App\Console\Commands\Telegram;

use App\Entities\Application;
use App\Entities\AuthCommand;
use App\Events\UserJoinFailEvent;
use App\Events\UserJoinSuccessEvent;
use App\Repositories\LogAuthStepRepository;
use App\Wrappers\authRequest\Request;
use App\Wrappers\authRequest\User as AuthUser;
use Exception;
use GuzzleHttp\Client;
use Telegram\Bot\Exceptions\TelegramSDKException;

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
		$user = $this->users->loadByTelegramProfile($from);

		/** @var LogAuthStepRepository $authSteps */
		$authSteps = app(LogAuthStepRepository::class);

		// -- Команда не найдена в кэше
		if (null === $authCommand) {
			$authCommand = new AuthCommand();
			$authCommand->command = $this->name;

			// Логируем полученную команду
			$authSteps->writeCommandStep($authCommand, $user->uuid);

			try {
				$replyMessage->setText('Команда не найдена');
				$this->replyWithMessage($replyMessage->get());
			}
			catch(TelegramSDKException $e) {
				$this->logger->error('Не удалось отправить собщению пользователю: ' . $e->getMessage());
			}

			event(new UserJoinFailEvent($this->name, 'Команда не найдена'));

			// Логируем ошибку авторизации
			$authSteps->writeFailResultStep($authCommand, $user->uuid, 'Команда не найдена');

			return;
		}
		// -- -- -- --

		// Логируем попытку авторизации
		$authSteps->writeCommandStep($authCommand, $user->uuid);

		// Удаляем команду из кэша
		$this->cache->forget($cacheKey);

		// -- Проверяем, возможно команда устарела
		$delta = time() - $authCommand->createStamp;
		if ($delta > AuthCommand::EXPIRED_TIME_SEC) {
			try {
				$replyMessage->setText('Команда не найдена');
				$this->replyWithMessage($replyMessage->get());
			}
			catch(TelegramSDKException $e) {
				$this->logger->error('Не удалось отправить собщению пользователю: ' . $e->getMessage());
			}

			event(new UserJoinFailEvent($this->name, 'Команда не найдена'));

			// Логируем ошибку авторизации
			$authSteps->writeFailResultStep($authCommand, $user->uuid, 'Команда устарела на ' . ($delta - AuthCommand::EXPIRED_TIME_SEC) . 'c');

			return;
		}
		// -- -- -- --

		$authKey     = $this->generateAuthKey();
		/** @var Application $application */
		$application = Application::find($authCommand->applicationUuid);

		//-- Отправляем запрс с авторизационными данными приложению
		$httpClient = new Client;
		// Пытаем отправить запрос в несколько попыток
		$isSuccessResponse = false;

		$authUser               = new AuthUser;
		$authUser->uuid         = $user->uuid;
		$authUser->username     = $user->username;
		$authUser->firstName    = $user->first_name;
		$authUser->lastName     = $user->last_name;

		if (null !== $user->profile_photo) {
			$authUser->profilePhotoUrl = '//cdn.authgram.ru/' . $user->profile_photo;
		}

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
				$this->logger->error('Не удалось отправить авторизационные данные приложению ' . $application->title . ': ' . $e->getMessage());
			}
		}
		//-- -- -- --

		if (false === $isSuccessResponse) {
			try {
				$replyMessage->setText('Ошибка авторизации. Попробуйте позже');
				$this->replyWithMessage($replyMessage->get());
			}
			catch (TelegramSDKException $e) {
				$this->logger->error('Не удалось отправить собщению пользователю: ' . $e->getMessage());
			}

			event(new UserJoinFailEvent($this->name, 'Не смогли получить ответ от сайта'));

			// Логируем ошибку авторизации
			$authSteps->writeFailResultStep($authCommand, $user->uuid, 'Не смогли получить ответ от сайта');

			return;
		}

		event(new UserJoinSuccessEvent($this->name, $authKey));

		// Логируем успешное завершение авторизации
		$authSteps->writeSuccessResultStep($authCommand, $user->uuid, [
			'Авторизация завершена за ' . (time() - $authCommand->createStamp) . 'c',
		]);

		try {
			$replyMessage->setText($application->success_auth_message);
			$this->replyWithMessage($replyMessage->get());
		}
		catch (TelegramSDKException $e) {
			$this->logger->error('Не удалось отправить собщению пользователю: ' . $e->getMessage());
		}
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