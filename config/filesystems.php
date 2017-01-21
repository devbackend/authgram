<?php

/**
 * Работа с файловой системой
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	'default' => 'local', // файловая система по-умолчанию
	'cloud'   => 's3',    // облачная файловая система по-умолчанию

	//-- Настройки различных файловых систем
	'disks'   => [
		'local'  => [
			'driver' => 'local',
			'root'   => storage_path('app'),
		],
		'public' => [
			'driver'     => 'local',
			'root'       => storage_path('app/public'),
			'visibility' => 'public',
		],
		's3'     => [
			'driver' => 's3',
			'key'    => 'your-key',
			'secret' => 'your-secret',
			'region' => 'your-region',
			'bucket' => 'your-bucket',
		],
	],
	//-- -- -- --
];
