<?php

/**
 * Параметры для авторизации пользователей в приложении
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	//-- Параметры по-умолчанию
	'defaults'  => [
		'guard'     => 'web',   // тип приложения, защищенный авторизацией
		'passwords' => 'owners', // таблица, в которой хранятся данные по доступам
	],
	//-- -- -- --

	//-- Защиты для типов приложений
	'guards'    => [
		'web' => [
			'driver'   => 'session',
			'provider' => 'owners',
		],

		'api' => [
			'driver'   => 'token',
			'provider' => 'applications',
		],
	],
	//-- -- -- --

	//-- Провайдеры данных доступа
	'providers' => [
		'owners' => [
			'driver' => 'eloquent',
			'model'  => \App\Entities\Owner::class,
		],
		'applications'  => [
			'driver' => 'eloquent',
			'model'  => \App\Entities\Application::class,
		]
	],
	//-- -- -- --
];
