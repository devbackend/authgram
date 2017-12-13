<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Jobs\SendMessageJob;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер реальной рассылки собщений влдаельцам приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class NotificationRealSendController extends AbstractNotificationSendController {
	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request) {
		$ownerIds = app(UserRepository::class)->getActiveOwnerIds();

		$text = $request->get('text');

		foreach ($ownerIds as $ownerId) {
			$message = $this->getMessage($text, $ownerId);

			app(Dispatcher::class)->dispatch(
				new SendMessageJob($message)
			);
		}

		return response()->json([]);
	}
}