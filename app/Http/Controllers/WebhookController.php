<?php
namespace App\Http\Controllers;

use App;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Контроллер для обработки web-хука от Telegram.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class WebhookController extends Controller {
	/**
	 * @param string $token Значение токена Telegram-бота
	 *
	 * @return Response
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke($token) {
		if (env('TELEGRAM_BOT_TOKEN') !== $token) {
			App::abort(401);
		}

		Telegram::getWebhookUpdates();

		return response('ok');
	}
}