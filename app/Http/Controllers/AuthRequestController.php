<?php
namespace App\Http\Controllers;

use App;
use App\Entities\Owner;
use AuthGramRequestHandler\AuthGramRequestHandler;

/**
 * Контроллер для обработки входящего запроса с авторизационными данными пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthRequestController extends Controller {
	/**
	 * Обработчик контроллера
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		$requestHandler = new AuthGramRequestHandler('3865dcfd8826cb974c39625e291e885awgi75zss0csqdrzliwjrv4s3c3xu');
		\Log::info(print_r($requestHandler, true));
		if (false === $requestHandler->isValidToken()) {
			App::abort(401);
		}

		$authRequest = $requestHandler->getRequest();

		$owner = Owner::where(Owner::USER_UUID, $authRequest->user->uuid)->first();
		if (null === $owner) {
			$owner = Owner::create([
				Owner::USER_UUID => $authRequest->user->uuid,
			]);
		}

		$owner->password = $authRequest->authKey;
		$owner->save();

		return 'ok';
	}
}