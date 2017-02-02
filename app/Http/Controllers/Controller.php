<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

/**
 * Базовый контроллер приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
		$viewDir = get_called_class(); // App\Http\Controllers\ExampleController
		$viewDir = explode('\\', $viewDir);
		$viewDir = end($viewDir); // ExampleController
		$viewDir = substr($viewDir, 0, -10); // Example
		$viewDir = camel_case($viewDir); // example

		return view($viewDir . '/' . $viewFile, $params);
	}
}
