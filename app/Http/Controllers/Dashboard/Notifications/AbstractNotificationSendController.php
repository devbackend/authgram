<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\BackOfficeController;

/**
 * Базовый класс контроллеров отправки сообщений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class AbstractNotificationSendController extends BackOfficeController {
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