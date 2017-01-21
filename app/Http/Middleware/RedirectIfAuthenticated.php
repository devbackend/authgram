<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Прослойка для редиректа в личный кабинет, если пользователь уже авторизован.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class RedirectIfAuthenticated {
	/**
	 * Handle an incoming request.
	 *
	 * @param  Request     $request Запрос
	 * @param  Closure     $next    Следующий шаг в архитектуре
	 * @param  string|null $guard
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		if (Auth::guard($guard)->check()) {
			return redirect('/home');
		}

		return $next($request);
	}
}
