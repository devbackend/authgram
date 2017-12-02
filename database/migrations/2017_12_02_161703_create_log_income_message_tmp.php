<?php

use Illuminate\Database\Schema\Blueprint;

class CreateLogIncomeMessageTmp extends BaseMigration {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
    public function up() {
	    $this->schema->create('log_income_message_tmp', function (Blueprint $table) {
		    $table->increments('id');
		    $table->uuid('user_uuid');
		    $table->text('message_data');
		    $table->timestamps();
	    });

	    $this->db->statement(
<<<SQL
INSERT INTO log_income_message_tmp (user_uuid, message_data, created_at, updated_at)
SELECT user_uuid, message_data, created_at, updated_at FROM log_income_messages ORDER BY created_at ASC
SQL
	    );
    }

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
    public function down() {
        $this->schema->drop('log_income_message_tmp');
    }
}
