<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Создание таблицы логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateLogsTable extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->create('logs', function(Blueprint $table) {
			$table->uuid('guid');
			$table->smallInteger('level');
			$table->string('category');
			$table->text('message');
			$table->string('file');
			$table->text('trace');
			$table->string('url');
			$table->string('ip');
			$table->string('method');
			$table->text('params');
			$table->timestamp('insert_stamp')->default($this->db->raw('CURRENT_TIMESTAMP(0)'));

			$table->softDeletes();

			$table->primary('guid');
		});
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->drop('logs');
	}
}
