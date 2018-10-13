<?php

use Illuminate\Database\Schema\Blueprint;

class AddLastMessageFailReason extends BaseMigration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->text('last_message_fail_reason')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->dropColumn('last_message_fail_reason');
		});
	}
}
