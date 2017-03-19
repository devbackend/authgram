<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {
	/**
	 * Примение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->string('slug', 32)->unique();
			$table->string('title');
			$table->text('content');
			$table->timestamps();
		});
	}

	/**
	 * Откат миграции.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		Schema::dropIfExists('pages');
	}
}
