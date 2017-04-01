<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Auth;
use Closure;

/**
 * Прослойка для проверки того, что владелец приложения авторизован.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CheckOwnerAuthMiddleware extends BaseMiddleware {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($request, Closure $next) {
		if (false === Auth::check()) {
			return redirect()->route(RouteServiceProvider::ROUTE_NAME_SIGN);
		}

		return $next($request);
	}
}
