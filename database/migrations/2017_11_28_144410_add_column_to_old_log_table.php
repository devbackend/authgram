<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Добавление колонки для переноса данных в старую таблицу логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AddColumnToOldLogTable extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->table('log_auth_attempt_tmp', function(Blueprint $table) {
			$table->boolean('is_moved')->default(false);
		});
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->table('log_auth_attempt_tmp', function(Blueprint $table) {
			$table->dropColumn('is_moved');
		});
	}
}
