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
		$requestData = $request->all();
		$user        = $requestData['user'];

		$owner = Owner::where(Owner::USER_UUID, $user['uuid'])->first(); /** @var Owner $owner */
		if (null === $owner) {
			$owner = Owner::create([
				Owner::USER_UUID => $user['uuid'],
			]);
		}

		$owner->password = $requestData['auth_key'];
		$owner->save();

		return 'ok';
	}
}