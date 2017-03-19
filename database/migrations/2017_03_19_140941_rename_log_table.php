<?php

use Illuminate\Database\Migrations\Migration;

class RenameLogTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::rename('income_message_log', 'income_message_logs');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::rename('income_message_logs', 'income_message_log');
	}
}
