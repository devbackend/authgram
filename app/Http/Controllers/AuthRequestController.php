<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Контроллер для обработки входящего запроса с авторизационными данными пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthRequestController extends Controller {
	public function __invoke(Request $request) {
		return 'ok';
	}
}