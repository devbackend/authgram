<?php

namespace App\Http\Controllers\Dashboard;

use App\Entities\Application;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Api as TelegramApi;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Контроллер для рассылки уведомлений владельцам приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class NotificationController extends Controller {
	/**
	 * Страница уведомлений.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function indexAction() {
		return $this->render('index');
	}

	/**
	 * Тестовая отправка уведомления.
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function testSendAction(Request $request) {
		$text = $request->get('text');

		$result = ['success' => true];

		try {
			$message = $this->getMessage($text, User::ADMIN_TELEGRAM_ID);

			$this->getTelegramApi()->sendMessage($message);
		} catch (TelegramSDKException $exception) {
			$result['success'] = false;
			$result['error']   = $exception->getMessage();
		}

		return response()->json($result);
	}

	/**
	 * Реальная отправка уведомлений.
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function realSendAction(Request $request) {
		/** @var Connection $db */
		$db = resolve(Connection::class);

		$telegramIds = $db->table(User::table())
			->select(User::TELEGRAM_ID)
			->distinct()
			->join(
				Application::table(),
				Application::table() . '.' . Application::OWNER_UUID,
				'=',
				User::table() . '.' . User::UUID
			)
			->where(User::NOTIFICATION_ENABLED, true)
			->pluck(User::TELEGRAM_ID)
		;

		$text = $request->get('text');

		$result = ['successCount' => 0, 'errorsCount' => 0];

		foreach ($telegramIds as $telegramId) {
			try {
				$message = $this->getMessage($text, $telegramId);

				$this->getTelegramApi()->sendMessage($message);

				$result['successCount']++;
			} catch (TelegramSDKException $exception) {
				$result['errorsCount']++;
			}
		}

		return response()->json($result);
	}

	/**
	 * Получение инстанса для работы с Telegram.
	 *
	 * @return TelegramApi
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function getTelegramApi(): TelegramApi {
		return resolve(TelegramApi::class);
	}

	/**
	 * Получение массива с настройками для отправки собщения.
	 *
	 * @param string $text      Текст сообщения
	 * @param int    $chatId    Идентификатор пользователя
	 *
	 * @return array
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function getMessage(string $text, int $chatId): array {
		$text = implode("\n\n", [
			'<b>Привет!</b>',
			$text,
			'--' . "\n" . 'Вы получили это собщение, так как являетесь владельцем приложения, которое использует авторизацию при помощи AuthGram',
			'Если Вы больше не хотите быть в курсе обновлений бота, отпишитесь от рассылки при помощи отправки команды /off',
		]);

		return [
			'chat_id'    => $chatId,
			'text'       => $text,
			'parse_mode' => 'HTML',
		];
	}
}