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
		'passwords' => 'users', // таблица, в которой хранятся данные по доступам
	],
	//-- -- -- --

	//-- Защиты для типов приложений
	'guards'    => [
		'web' => [
			'driver'   => 'session',
			'provider' => 'users',
		],

		'api' => [
			'driver'   => 'token',
			'provider' => 'users',
		],
	],
	//-- -- -- --

	//-- Провайдеры данных доступа
	'providers' => [
		'users' => [
			'driver' => 'eloquent',
			'model'  => App\User::class,
		],
	],
	//-- -- -- --

	//-- Настройки сброса пароля
	'passwords' => [
		'users' => [
			'provider' => 'users',
			'table'    => 'password_resets',
			'expire'   => 60,
		],
	],
	//-- -- -- --
];
