<?php

namespace App\Http\Middleware;

use App\Entities\Owner;
use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckAuthKey {
	const REQUEST_PARAM_AUTH_KEY = 'auth_key';

	/**
	 * Обработка запроса.
	 *
	 * @param  Request $request Инстанс запроса
	 * @param  Closure $next    Функция для дальнейшего прохождения запроса
	 *
	 * @return mixed
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($request, Closure $next) {
		if ($request->has(static::REQUEST_PARAM_AUTH_KEY)) {
			$authKey = $request->get(static::REQUEST_PARAM_AUTH_KEY);
			$owner = Owner::where(Owner::PASSWORD, $authKey)->first();/** @var Owner $owner */
			if (null !== $owner) {
				Auth::login($owner, true);
			}

			return redirect($request->url());
		}

		return $next($request);
	}
}
