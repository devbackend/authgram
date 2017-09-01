<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

/**
 * Отлов исключительных ситуаций.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Handler extends ExceptionHandler {
	/** @var string[] Список исключительных ситуаций, которые не надо логировать */
	protected $dontReport = [
		//AuthenticationException::class,
		//AuthorizationException::class,
		//HttpException::class,
		//ModelNotFoundException::class,
		//TokenMismatchException::class,
		//ValidationException::class,
	];

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function report(Exception $exception) {
		try {
			$logger = $this->container->make(LoggerInterface::class);
		} catch (Exception $e) {
			throw $exception; // бросаем оригинальное исключение
		}

		$logger->error(
			$exception->getMessage(),
			[
				'file'      => $exception->getFile() . ':' . $exception->getLine(),
				'trace'     => $exception->getTraceAsString(),
				'category'  => get_class($exception),
			]
		);
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function render($request, Exception $exception) {
		return parent::render($request, $exception);
	}

	/**
	 * Превращение исключительной ситуации при аутентификации в 401-ый ответ
	 *
	 * @param  Request                  $request    Инстанс запроса
	 * @param  AuthenticationException  $exception  Исключительная ситуация
	 *
	 * @return Response
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function unauthenticated($request, AuthenticationException $exception) {
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}
}
