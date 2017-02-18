<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOwnersTable extends Migration {
	/**
	 * Применение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::create('owners', function(Blueprint $table) {
			$table->increments('id');
			$table->uuid('user_uuid');
			$table->string('password', 64)->default('');
			$table->rememberToken();
			$table->timestamps();

			$table->unique('user_uuid');
		});
	}

	/**
	 * Откат миграции.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		Schema::dropIfExists('owners');
	}
}
