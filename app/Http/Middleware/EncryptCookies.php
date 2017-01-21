<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * Прослойка шифрования куков.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class EncryptCookies extends BaseEncrypter {
	/** @var string[] Ключи, которые не надо шифровать */
	protected $except = [];
}
