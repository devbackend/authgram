<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Создание таблицы приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateApplicationsTable extends Migration {
	public function up() {
		Schema::create('applications', function(Blueprint $table) {
			$table->uuid('uuid');
			$table->uuid('owner_uuid');
			$table->string('title');
			$table->string('website');
			$table->string('api_token', 60);
			$table->timestamps();

			$table->primary('uuid');
			$table->unique('api_token');
		});
	}

	public function down() {
		Schema::drop('applications');
	}
}
