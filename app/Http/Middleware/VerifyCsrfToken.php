<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

/**
 * Проверка CSRF-токена при отправке запросов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class VerifyCsrfToken extends BaseVerifier {
	/** @var string[] URL-адреса, для которых не надо проверять токен */
	protected $except = [
		'webhook/*', // webhook telegram бота
	];
}
