<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogAuthAttempts extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('log_auth_attempts', function (Blueprint $table) {
			$table->increments('id');
			$table->smallInteger('step');
			$table->uuid('application_uuid')->default('00000000-0000-0000-0000-000000000000');
			$table->uuid('user_uuid')->default('00000000-0000-0000-0000-000000000000');
			$table->string('command', 6);
			$table->json('additional_info');
			$table->timestamp('insert_stamp');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('log_auth_attempts');
	}
}
