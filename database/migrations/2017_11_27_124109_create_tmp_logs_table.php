<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Создание временной таблицы для перехода на новый формат логирования
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateTmpLogsTable extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->create('log_auth_attempt_tmp', function (Blueprint $table) {
			$table->increments('id');
			$table->smallInteger('step');
			$table->uuid('application_uuid')->default('00000000-0000-0000-0000-000000000000');
			$table->uuid('user_uuid')->default('00000000-0000-0000-0000-000000000000');
			$table->string('command', 6);
			$table->json('additional_info');
			$table->timestamp('insert_stamp');
		});

		$this->db->statement(
<<<SQL
INSERT INTO log_auth_attempt_tmp (id, step, application_uuid , user_uuid, command, additional_info, insert_stamp)
SELECT * FROM log_auth_attempts
SQL
		);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->dropIfExists('log_auth_attempt_tmp');
	}
}
