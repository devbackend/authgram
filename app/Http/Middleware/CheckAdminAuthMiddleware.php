<?php

namespace App\Http\Middleware;

use App\Entities\Policy;
use Closure;
use Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
			throw new HttpException(403);
		}

		return $next($request);
	}
}