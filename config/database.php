<?php

/**
 * Настройки работы с базой данных
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	'fetch'       => PDO::FETCH_OBJ,                  // PDO Fetch Style
	'default'     => env('DB_CONNECTION', 'pgsql'),   // тип СУБД по-умолчанию

	//-- Настройки соединения с базой данных для различных СУБД
	'connections' => [
		'sqlite' => [
			'driver'   => 'sqlite',
			'database' => env('DB_DATABASE', database_path('database.sqlite')),
			'prefix'   => '',
		],
		'pgsql'  => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST',        'localhost'),
			'port'     => env('DB_PORT',        '5432'),
			'database' => env('DB_DATABASE',    'forge'),
			'username' => env('DB_USERNAME',    'forge'),
			'password' => env('DB_PASSWORD',    ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
			'sslmode'  => 'prefer',
		],
	],

	'redis' => [
		'client'  => 'predis',
		'default' => [
			'host'     => env('REDIS_HOST',     '127.0.0.1'),
			'password' => env('REDIS_PASSWORD', null),
			'port'     => env('REDIS_PORT',     6379),
			'database' => 0,
		],

	],
	//-- -- -- --

	'migrations' => 'migrations', // название таблицы с миграциями
];
