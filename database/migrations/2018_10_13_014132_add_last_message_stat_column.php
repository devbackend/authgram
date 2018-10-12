<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastMessageStatColumn extends BaseMigration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->string('last_message_status')->nullable();
			$table->string('last_message_attempts')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		$this->schema->table('users', function(Blueprint $table) {
			$table->dropColumn('last_message_status');
			$table->dropColumn('last_message_attempts');
		});
	}
}
