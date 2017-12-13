<?php
namespace App\Http\Controllers;

use App;
use App\Entities\LogIncomeMessage;
use App\Exceptions\Handler;
use App\Exceptions\UndefinedMessageException;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Throwable;

/**
 * Контроллер для обработки web-хука от Telegram.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class WebhookController extends Controller {
	/** @var UserRepository Репозиторий пользователей */
	private $userRepository;

	/**
	 * @param string $token       Значение токена Telegram-бота
	 * @param Api    $telegramApi Инстанс бота telegram
	 *
	 * @return Response
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke($token, Api $telegramApi) {
		if (env('TELEGRAM_BOT_TOKEN') !== $token) {
			App::abort(401);
		}

		try {
			$this->handleUpdateObject(
				$telegramApi->commandsHandler(true)
			);
		}
		catch (Throwable $e) {
			$this->logger->error('Не удалось обработать входящее сообщение: ' . $e->getMessage());
		}

		return response('ok');
	}

	/**
	 * Обработка сообщений к боту в dev-среде.
	 *
	 * @param Api $telegramApi
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function devAction(Api $telegramApi) {
		if ('local' !== app()->environment()) {
			App::abort(404);
		}

		$updates = $telegramApi->commandsHandler();

		foreach ($updates as $update) {
			try {
				$this->handleUpdateObject($update);
			}
			catch (Throwable $e) {
				app(Handler::class)->report($e);
			}
		}

		return 'Обработано обновлений: ' . count($updates);
	}

	/**
	 * Обработка обновления.
	 *
	 * @param Update $update
	 *
	 * @throws UndefinedMessageException
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function handleUpdateObject(Update $update) {
		$updateMessage = $update->getMessage();
		if (null === $updateMessage) {
			throw new UndefinedMessageException($update);
		}

		$telegramUser   = $updateMessage->getFrom();
		$user           = $this->getUserRepository()->loadByTelegramProfile($telegramUser);

		$message = serialize($update);

		LogIncomeMessage::create([
			LogIncomeMessage::USER_UUID    => $user->uuid,
			LogIncomeMessage::MESSAGE_DATA => addslashes($message),
		]);
	}

	/**
	 * Получение репозитория пользователей
	 *
	 * @return UserRepository
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	private function getUserRepository(): UserRepository {
		if (null === $this->userRepository) {
			$this->userRepository = resolve(UserRepository::class);
		}

		return $this->userRepository;
	}
}