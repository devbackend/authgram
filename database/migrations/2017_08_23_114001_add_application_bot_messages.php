<?php

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;

/**
 * Добавление полей для сообщений пользователямпри авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AddApplicationBotMessages extends BaseMigration {
	const TABLE_NAME = 'applications';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->table(static::TABLE_NAME, function(Blueprint $table) {
			$table->addColumn('TEXT', 'success_auth_message')->nullable();
		});

		/** @var Connection $db */
		$db = resolve(Connection::class);

		$db->table(static::TABLE_NAME)->update([
			'success_auth_message'  => "Вы успешно авторизовались.\n\nВернитесь в браузер, чтобы продолжить работу с сайтом.",
		]);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->table(static::TABLE_NAME, function(Blueprint $table) {
			$table->dropColumn('success_auth_message');
		});
	}
}
