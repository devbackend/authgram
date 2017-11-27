<?php

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class FillTmpTable extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		$this->db->statement(
<<<SQL
TRUNCATE TABLE log_auth_attempt_tmp;
SQL
		);

		$this->db->statement(
<<<SQL
INSERT INTO log_auth_attempt_tmp (step, application_uuid , user_uuid, command, additional_info, insert_stamp)
SELECT step, application_uuid , user_uuid, command, additional_info, insert_stamp FROM log_auth_attempts
SQL
		);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		$this->db->statement(
<<<SQL
TRUNCATE TABLE log_auth_attempt_tmp
SQL
		);
	}
}
