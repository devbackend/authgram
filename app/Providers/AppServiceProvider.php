<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Запуск сервис-провайдеров приложения
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function boot() {

	}

	/**
	 * Регистрация сервис-провайдеров приложения
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function register() {
		if ('production' !== $this->app->environment()) {
			$this->app->register(IdeHelperServiceProvider::class);
		}
	}
}
