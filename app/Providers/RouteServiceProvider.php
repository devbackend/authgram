<?php

namespace App\Providers;

use App\Http\Kernel;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Сервис-провайдер для работы с роутами.
 *
 * @todo-05.02.2017-krivonos.iv сделать прохождение по файлам по маске, чтоб можно было легко добавлять и удалять файлы
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class RouteServiceProvider extends ServiceProvider {
	const ROUTE_NAME_WEBHOOK    = 'webhook';
	const ROUTE_NAME_HOMEPAGE   = 'homepage';
	const ROUTE_NAME_SIGN       = 'sign';

	/**
	 * Определение роутов приложения.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function map() {
		$this->mapApiRoutes();
		$this->mapWebRoutes();
		$this->mapDashboardRoutes();
		$this->mapBroadcastRoutes();
	}

	/**
	 * Группировка роутов, доступных по HTTP.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function mapWebRoutes() {
		Route::group([
			'middleware' => [Kernel::MIDDLEWARE_GROUP_WEB],
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
			'prefix'     => 'api',
		], function($router) {
			require base_path('routes/api.php');
		});
	}

	/**
	 * Группировка роутов для вещания.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function mapBroadcastRoutes() {
		require base_path('routes/channels.php');
	}

	/**
	 * Роуты для админки.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function mapDashboardRoutes() {
		Route::group([
			'middleware'    => [Kernel::MIDDLEWARE_GROUP_WEB, Kernel::MIDDLEWARE_ALIAS_AUTH, Kernel::MIDDLEWARE_ALIAS_AUTH_ADMIN],
			'prefix'        => 'dashboard',
		], function ($router) {
			require base_path('routes/back-office.php');
		});
	}
}
