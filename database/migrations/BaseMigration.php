<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Базовый класс миграций
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class BaseMigration extends Migration {
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