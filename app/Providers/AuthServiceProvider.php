<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Сервис-провайдер для работы с аутентификацией и авторизацией.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();
	}
}
