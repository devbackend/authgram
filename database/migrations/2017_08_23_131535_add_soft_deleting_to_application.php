<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Добавление поля 'deleted_at' в таблицу приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AddSoftDeletingToApplication extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->table('applications', function (Blueprint $table) {
			$table->softDeletes();
		});
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {}
}
