<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use ReflectionClass;

/**
 * Базовый контроллер приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/** @var Repository Провайдер для работы с кэшем */
	protected $cache;

	/** @var Log Провайдер для работы с логгированием */
	protected $logger;

	/**
	 * @param Log        $logger    Инстанс логгера
	 * @param Repository $cache     Инстанс для работы с кэшем
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(Log $logger, Repository $cache) {
		$this->logger   = $logger;
		$this->cache    = $cache;
	}

	/**
	 * Отрисовка шаблона.
	 *
	 * @param string    $viewFile   Название файла шаблона
	 * @param string[]  $params     Параметры, передаваемые в шаблон
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function render($viewFile, $params = []) {
		$class = new ReflectionClass(self::class);

		$controllerPathParts = get_called_class(); // App\Http\Controllers\ExampleController
		$controllerPathParts = str_replace($class->getNamespaceName() . '\\', '', $controllerPathParts); // ExampleController
		$controllerPathParts = explode('\\', $controllerPathParts);


		foreach ($controllerPathParts as $key => $controllerPathPart) {
			$controllerPathPart = str_replace('Controller', '', $controllerPathPart);
			$controllerPathPart = kebab_case($controllerPathPart);

			$controllerPathParts[$key] = $controllerPathPart;
		}

		return view(implode('.', $controllerPathParts) . '.' . $viewFile, $params);
	}
}
