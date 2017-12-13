<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Entities\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Контроллер тестовой отправки сообщения из рассылки.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class NotificationTestSendController extends AbstractNotificationSendController {
	/**
	 * Тестовая отправка уведомления.
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request) {
		$text = $request->get('text');

		$result = ['success' => true];

		try {
			$message = $this->getMessage($text, User::ADMIN_TELEGRAM_ID);

			app(Api::class)->sendMessage($message);
		} catch (TelegramSDKException $exception) {
			$result['success'] = false;
			$result['error']   = $exception->getMessage();
		}

		return response()->json($result);
	}
}