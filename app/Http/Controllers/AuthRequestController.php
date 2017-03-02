<?php
namespace App\Http\Controllers;

use App\Entities\Owner;
use Illuminate\Http\Request;

/**
 * Контроллер для обработки входящего запроса с авторизационными данными пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthRequestController extends Controller {
	/**
	 * Обработчик контроллера
	 *
	 * @param Request $request Данные запроса
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request) {
		/** @var \App\Wrappers\authRequest\Request $authRequest */
		$authRequest = @json_decode($request->getContent());

		$user = $authRequest->user;

		$owner = Owner::where(Owner::USER_UUID, $user->uuid)->first();
		if (null === $owner) {
			$owner = Owner::create([
				Owner::USER_UUID => $user->uuid,
			]);
		}

		$owner->password = $authRequest->authKey;
		$owner->save();

		return 'ok';
	}
}