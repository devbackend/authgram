<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommandsTable extends Migration {
	const OLD_TABLE_NAME = 'auth_codes';
	const NEW_TABLE_NAME = 'auth_commands';

	/**
	 * Применение миграции.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		DB::beginTransaction();
		DB::table(static::OLD_TABLE_NAME)->truncate();
		DB::commit();

		Schema::table(static::OLD_TABLE_NAME, function (Blueprint $table) {
			$table->dropColumn('code');
			$table->string('command', 6);

			$table->primary('command');

			$table->rename(static::NEW_TABLE_NAME);
		});
	}

	/**
	 * Откат миграции.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		DB::beginTransaction();
		DB::table(static::NEW_TABLE_NAME)->truncate();
		DB::commit();

		Schema::table(static::NEW_TABLE_NAME, function (Blueprint $table) {
			$table->dropColumn('command');
			$table->string('code', 6);

			$table->primary('code');

			$table->rename(static::OLD_TABLE_NAME);
		});
	}
}
