<?php
namespace App\Entities;

use Eloquent;
use Exception;
use Illuminate\Http\Request;

/**
 * Базовый класс моделей.
 *
 * @method static $this create($attributes = []) Создание модели
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class Entity extends Eloquent {
	/**
	 * Создание модели на основе данных реквеста.
	 *
	 * @param Request $request Реквест
	 *
	 * @return static
	 *
	 * @throws Exception
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function createByRequest(Request $request) {
		$entity = new static;

		foreach ($entity->fillable as $field) {
			$entity->$field = $request->input($field) ?? '';
		}

		if (false === $entity->save()) {
			throw new Exception('Произошла ошибка при создании модели');
		}

		return $entity;
	}

	/**
	 * Получение имени таблицы, с которой связана модель.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function table() {
		return (new static)->table;
	}
}