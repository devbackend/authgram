<?php

/**
 * Удаление старых таблиц логов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DropOldLogsTables extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->schema->dropIfExists('log_auth_attempts');
		$this->schema->dropIfExists('log_auth_attempt_tmp');
	}
}
