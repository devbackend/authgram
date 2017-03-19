<?php
namespace App\Repositories;

/**
 * Абстрактный класс репозитория с данными.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class Repository {
	/**
	 * Поулчение записи по идентификатору
	 *
	 * @param mixed $id Идентификатор
	 *
	 * @return mixed
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	abstract public function get($id);
}