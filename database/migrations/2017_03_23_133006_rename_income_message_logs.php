<?php

use Illuminate\Database\Migrations\Migration;

class RenameIncomeMessageLogs extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::rename('income_message_logs', 'log_income_messages');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::rename('log_income_messages', 'income_message_logs');
	}
}
