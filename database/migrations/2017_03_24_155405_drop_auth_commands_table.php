<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Удаление таблицы для хранения команд авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DropAuthCommandsTable extends Migration {
	/**
	 * Применение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::dropIfExists('auth_commands');
	}
}
