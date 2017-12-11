<?php

use Illuminate\Database\Schema\Blueprint;

/**
 * Добавление поля с URL-адресом фото профиля пользователей.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AddAvatarUrlToUser extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->string('profile_photo')->nullable();
		});
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->dropColumn('profile_photo');
		});
	}
}
