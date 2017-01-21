<?php

/**
 * Настройки работы с почтой
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	'driver' => env('MAIL_DRIVER', 'smtp'),  // драйер работы с почтой по-умолчанию
	'host'   => env('MAIL_HOST', ''),        // адрес почтового сервера
	'port'   => env('MAIL_PORT', 587),       // порт почтового сервера

	//-- Данные отправителя
	'from'   => [
		'address' => '',
		'name'    => '',
	],
	//-- -- -- --

	'encryption'    => env('MAIL_ENCRYPTION', 'tls'),  // шифрование
	'username'      => env('MAIL_USERNAME'),           // имя пользователя
	'password'      => env('MAIL_PASSWORD'),            // пароль
	'sendmail'      => '/usr/sbin/sendmail -bs',        // путь до исполняемого файла sendmail на сервере

];
