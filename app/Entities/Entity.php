<?php
namespace App\Entities;

use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Http\Request;

/**
 * Базовый класс моделей.
 *
 * @property Carbon $created_at Дата создания записи
 * @property Carbon $updated_at Дата обновления записи
 * @property Carbon $deleted_at Дата удаления записи
 *
 * @method static $this create($attributes = []) Создание модели
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class Entity extends Eloquent {
	const DELETED_AT = 'deleted_at';

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

		$entity->loadRequest($request);

		if (false === $entity->save()) {
			throw new Exception('Произошла ошибка при создании модели');
		}

		return $entity;
	}

	/**
	 * Загрузка данных из входящего запроса.
	 *
	 * @param Request $request
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function loadRequest(Request $request) {
		$requestData = $request->all();
		foreach ($requestData as $field => $value) {
			if (false === in_array($field, $this->fillable)) {
				continue;
			}

			$this->setAttribute($field, $value);
		}

		return $this;
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

	/**
	 * Название первичного ключа
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	/**
	 * Получение времени создания в человеко-понятном виде.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getCreationTime() {
		if (false === $this->timestamps) {
			return '';
		}

		return ($this->created_at->diffInHours() < 24
			? $this->created_at->diffForHumans()
			: $this->created_at->format('d.m.Y H:i')
		);
	}
}