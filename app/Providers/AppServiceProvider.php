<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Api;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Регистрация сервис-провайдеров приложения
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function register() {
		if ('production' !== $this->app->environment()) {
			$this->app->register(IdeHelperServiceProvider::class);
		}

		$this->app->bind(Api::class, function() {
			return new Api(
				app('telegram.bot_token')
			);
		});
	}
}
