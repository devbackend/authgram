<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MoveRedirectColumn extends Migration {
	/**
	 * Применение миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function up() {
		Schema::table('applications', function (Blueprint $table) {
			$table->dropColumn('redirect_url');
		});
	}

	/**
	 * Отмена миграции
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function down() {
		Schema::table('applications', function (Blueprint $table) {
			$table->string('redirect_url');
		});
	}
}
