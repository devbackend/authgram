<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Создание таблицы для хранения кодов авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateAuthCodesTable extends Migration {
	/**
	 * Применение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::create('auth_codes', function (Blueprint $table) {
			$table->integer('code');
			$table->uuid('application_uuid');
			$table->timestamp('expired_at');

			$table->primary('code');
		});
	}

	/**
	 * Отмена миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		Schema::drop('auth_codes');
	}
}
