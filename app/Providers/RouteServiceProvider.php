<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Сервис-провайдер для работы с роутами.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class RouteServiceProvider extends ServiceProvider {
	/** @var string Неймспейс, в котором хранятся контроллеры приложения. */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Определение роутов приложения.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function map() {
		$this->mapApiRoutes();
		$this->mapWebRoutes();
	}

	/**
	 * Группировка роутов, доступных по HTTP.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function mapWebRoutes() {
		Route::group([
			'middleware' => 'web',
			'namespace'  => $this->namespace,
		], function($router) {
			require base_path('routes/web.php');
		});
	}

	/**
	 * Группировка роутов для доступа к API функциям приложения.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function mapApiRoutes() {
		Route::group([
			'middleware' => 'api',
			'namespace'  => $this->namespace,
			'prefix'     => 'api',
		], function($router) {
			require base_path('routes/api.php');
		});
	}
}
