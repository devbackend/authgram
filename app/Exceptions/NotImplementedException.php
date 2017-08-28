<?php

namespace App\Exceptions;

use Exception;

/**
 * Ислючение, бросаемое при неимплементированном поведении.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class NotImplementedException extends Exception {

	/**
	 * @param string $noImplemented Стрококовое представление не имплементированного метода или класса
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(string $noImplemented) {
		parent::__construct('Нет описанного поведения для ' . $noImplemented);
	}
}