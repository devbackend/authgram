<?php
namespace App\Http\Controllers;

use App;
use App\Entities\LogIncomeMessage;
use App\Entities\User;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Контроллер для обработки web-хука от Telegram.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class WebhookController extends Controller {
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

		$this->handleUpdateObject(
			$telegramApi->commandsHandler(true)
		);

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
			$this->handleUpdateObject($update);
		}

		return 'Обработано обновлений: ' . count($updates);
	}

	/**
	 * Обработка обновления.
	 *
	 * @param Update $update
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function handleUpdateObject(Update $update) {
		$from = $update->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);

		$message = serialize($update);

		LogIncomeMessage::create([
			LogIncomeMessage::USER_UUID    => $user->uuid,
			LogIncomeMessage::MESSAGE_DATA => addslashes($message),
		]);
	}
}