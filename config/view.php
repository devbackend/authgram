<?php

/**
 * Настройки работы с шаблонами
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	//-- Директория с шаблонами
	'paths' => [
		realpath(base_path('resources/views')),
	],
	//-- -- -- --

	'compiled' => realpath(storage_path('framework/views')), // директория с скомпилированными шаблонами
];
