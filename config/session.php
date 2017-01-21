<?php

/**
 * Настройки работы с сессиями.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	'driver'            => env('SESSION_DRIVER', 'file'),       // драйвер работы с сессиями по-умолчанию
	'lifetime'          => 120,                                 // время жизни (в минутах) сессии после закрытия браузера
	'expire_on_close'   => false,                               // удалять ли сессию при закрытии браузера
	'encrypt'           => false,                               // необходимо ли шифровать сессиию
	'files'             => storage_path('framework/sessions'),  // место хранения файлов с ссессиями (при выборе file в качестве драйвера)
	'connection'        => null,                                // какое соединение использовать если в качестве драйвера выбрана база данных
	'table'             => 'sessions',                          // название таблицы, в которой будут храниться сессии, если в качестве драйвера выбрана база данных
	'cookie'            => 'laravel_session',                   // ключ, в котором будет храниться идентификатор сессии
	'store'             => null,
	'lottery'           => [2, 100],
	'path'              => '/',
	'domain'            => env('SESSION_DOMAIN', null),
	'secure'            => env('SESSION_SECURE_COOKIE', false),
	'http_only'         => true,
];
