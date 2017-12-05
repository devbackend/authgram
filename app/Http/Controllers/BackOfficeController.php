<?php

namespace App\Http\Controllers;

use ReflectionClass;

/**
 * Базовый контроллер панели управления.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class BackOfficeController extends Controller {
	/**
	 * @inheritdoc
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

		return view('layouts.back-office', [
			'content' => view(implode('.', $controllerPathParts), $params),
		]);
	}
}