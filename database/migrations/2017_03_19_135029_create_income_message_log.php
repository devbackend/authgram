<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIncomeMessageLog extends Migration {
	/**
	 * Применение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::create('income_message_log', function (Blueprint $table) {
			$table->increments('id');
			$table->uuid('user_uuid');
			$table->text('message_data');
			$table->timestamps();
		});
	}

	/**
	 * Откат миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		Schema::dropIfExists('income_message_log');
	}
}
