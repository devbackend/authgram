<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Создание таблицы логирования шагов авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateLogAuthStepsTable extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->create('log_auth_steps', function(Blueprint $table) {
			$table->uuid('guid');
			$table->uuid('attempt_guid');
			$table->uuid('application_uuid');
			$table->uuid('user_uuid');
			$table->smallInteger('step');
			$table->string('command');
			$table->text('message');
			$table->timestamp('insert_stamp');

			$table->primary('guid');
		});
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->drop('log_auth_steps');
	}
}
