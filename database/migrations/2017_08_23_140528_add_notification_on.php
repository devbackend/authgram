<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Добавление поля "Подписан на уведомления" для владельцев приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AddNotificationOn extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->boolean('notification_enabled')->default(true);
		});
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->dropColumn('notification_enabled');
		});
	}
}
