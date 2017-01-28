<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {
	/**
	 * Применение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::create('users', function(Blueprint $table) {
			$table->uuid('uuid');
			$table->integer('telegram_id');
			$table->string('username');
			$table->string('first_name');
			$table->string('last_name');
			$table->timestamps();

			$table->primary('uuid');
			$table->unique('telegram_id');
		});
	}

	/**
	 * Отмена миграции.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		Schema::drop('users');
	}
}
