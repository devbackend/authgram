<?php
namespace App\Http\Middleware;

use Closure;
use Request;

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class BaseMiddleware {
	/**
	 * Обработка запроса
	 *
	 * @param  Request  $request    Текущий запрос
	 * @param  Closure  $next       Следующий обработчик запроса
	 *
	 * @return mixed
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	abstract public function handle($request, Closure $next);
}