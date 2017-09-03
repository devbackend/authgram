<?php
namespace App\Repositories;

use App\Entities\Entity;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Connection;

/**
 * Абстрактный класс репозитория с данными.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class Repository {
	/** @var Entity Модель, которая обрабатывается репозиторием */
	protected $entity;

	/** @var Cache Провайдер для работы с кэшем */
	protected $cache;

	/** @var Connection */
	protected $db;

	/**
	 * @param Cache      $cache
	 * @param Connection $db
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(Cache $cache, Connection $db) {
		$this->cache = $cache;
		$this->db    = $db;

		$this->initEntity();

	}

	/**
	 * Поулчение записи по идентификатору
	 *
	 * @param mixed $id Идентификатор
	 *
	 * @return Entity|null
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function get($id) {
		return $this->entity->find($id);
	}

	/**
	 * Получение последних записей.
	 *
	 * @param int $count Необходимо количество
	 *
	 * @return Entity[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getLastRecords(int $count = 10) {
		$cacheKey = $this->getCacheKey(__METHOD__, [$count, static::class]);
		$records  = $this->cache->get($cacheKey);
		if (null === $records) {
			$orderField = (property_exists($this->entity, Entity::CREATED_AT)
				? Entity::CREATED_AT
				: $this->entity->getPrimaryKey()
			);

			$records = $this->entity->orderBy($orderField, SORT_DESC)->take($count)->get();

			$this->cache->put($cacheKey, $records, 15);
		}

		return $records;
	}

	/**
	 * Получение инстанса модели
	 *
	 * @return Entity
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getEntity(): Entity {
		return $this->entity;
	}

	/**
	 * Получение ключа кэширования.
	 *
	 * @param string    $method     Название метода для которого проверяются данные
	 * @param array     $params     Параметры метода
	 * @param int       $version    Необходимая версия ключа
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function getCacheKey($method, $params = [], $version = 1) {
		foreach ($params as $key => $value) {
			if (is_array($value)) {
				$params[$key] = md5(implode('', $params));
			}
			elseif (is_bool($value)) {
				$params[$key] = ($value ? 'true' : 'false');
			}
		}

		return $method . '(' . implode(',', $params) . ')' . (1 !== $version ? $version : '');
	}

	/**
	 * Инициализация сущности
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	abstract protected function initEntity();
}