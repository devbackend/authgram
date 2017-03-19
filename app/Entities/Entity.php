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
	 * @param Request $request Данные запроса
	 *
	 * @return static
	 *
	 * @throws Exception
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function createByRequest(Request $request) {
		$entity = new static;

		$requestData = $request->all();
		foreach ($requestData as $field => $value) {
			if (false === in_array($field, $entity->fillable)) {
				continue;
			}

			$entity->$field = $value;
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
		return (new static)->getTable();
	}
}