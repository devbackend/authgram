<?php
namespace App\Http\Controllers;

use App;
use App\Entities\IncomeMessageLog;
use App\Entities\User;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

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

		/** @var Update $update */
		$update = Telegram::getWebhookUpdates();
		Telegram::commandsHandler(true);

		$from = $update->getMessage()->getFrom();
		$user = User::loadByTelegramProfile($from);
		IncomeMessageLog::create([
			IncomeMessageLog::USER_UUID     => $user->uuid,
			IncomeMessageLog::MESSAGE_DATA  => json_encode($update),
		]);

		return response('ok');
	}
}