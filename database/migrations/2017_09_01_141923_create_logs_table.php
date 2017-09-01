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
			$table->text('message');
			$table->text('trace');
			$table->timestamp('insert_stamp')->default($this->db->raw('CURRENT_TIMESTAMP(0)'));

			$table->primary('guid');
		});

		$this->db->statement('ALTER TABLE logs ALTER COLUMN guid SET DEFAULT uuid_generate_v4();');
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
