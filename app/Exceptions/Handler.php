<?php

namespace App\Exceptions;

use App\Entities\User;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Telegram\Bot\Api;

/**
 * Отлов исключительных ситуаций.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Handler extends ExceptionHandler {
	/** @var string[] Список исключительных ситуаций, которые не надо логировать */
	protected $dontReport = [
		//AuthenticationException ::class,
		//AuthorizationException  ::class,
		//HttpException           ::class,
		//ModelNotFoundException  ::class,
		//TokenMismatchException  ::class,
		//ValidationException     ::class,
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
			app(Api::class)->sendMessage([
				'chat_id'   => User::ADMIN_TELEGRAM_ID,
				'text'      => 'Приложение упало: ' . $e->getMessage(),
			]);

			throw new HttpException(500);
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
	 * @param  Request $request Инстанс запроса
	 *
	 * @return Response
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function unauthenticated($request) {
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}
}
