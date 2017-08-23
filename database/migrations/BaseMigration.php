<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;

/**
 * Базовый класс миграций
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class BaseMigration extends Migration {
	/** @var Builder */
	protected $schema;

	/**
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct() {
		$this->schema = resolve(Builder::class);
	}

	/**
	 * Применение миграции.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {}

	/**
	 * Откат миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {}
}