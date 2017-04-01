<?php

namespace App\Http\Middleware;

use App;
use App\Entities\Policy;
use Closure;
use Gate;

/**
 * Прослойка для проверки того, что авторизованный пользователь является админом сайта.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CheckAdminAuthMiddleware extends BaseMiddleware {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($request, Closure $next) {
		if (false === Gate::allows(Policy::ADMIN_ACTION)) {
			App::abort(403);
		}

		return $next($request);
	}
}