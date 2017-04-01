<?php

namespace App\Providers;

use App\Entities\Owner;
use App\Entities\Policy;
use App\Entities\User;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Сервис-провайдер для работы с аутентификацией и авторизацией.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthServiceProvider extends ServiceProvider {
	/** @var string[] */
	protected $policies = [];

	/**
	 * Запуск провайдера.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function boot() {
		$this->registerPolicies();

		//-- Инициализация прав
		Gate::define(Policy::ADMIN_ACTION, function (Owner $owner) {
			return (User::ADMIN_TELEGRAM_ID === $owner->user->telegram_id);
		});
		//-- -- -- --
	}
}
