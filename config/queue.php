<?php

/**
 * Настройка работы с очередями
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
return [
	'default'     => env('QUEUE_DRIVER', 'sync'), // Драйвер очереди по-умолчанию

	//-- Настройки для различных драйверов и систем очереди
	'connections' => [
		'sync'       => [
			'driver' => 'sync',
		],
		'database'   => [
			'driver'      => 'database',
			'table'       => 'jobs',
			'queue'       => 'default',
			'retry_after' => 90,
		],
		'beanstalkd' => [
			'driver'      => 'beanstalkd',
			'host'        => 'localhost',
			'queue'       => 'default',
			'retry_after' => 90,
		],
		'sqs'        => [
			'driver' => 'sqs',
			'key'    => 'your-public-key',
			'secret' => 'your-secret-key',
			'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
			'queue'  => 'your-queue-name',
			'region' => 'us-east-1',
		],
		'redis'      => [
			'driver'      => 'redis',
			'connection'  => 'default',
			'queue'       => 'default',
			'retry_after' => 90,
		],
	],
	//-- -- -- --

	//-- Настройки сохранения проваленных задач в очереди
	'failed'      => [
		'database' => env('DB_CONNECTION', 'mysql'),
		'table'    => 'failed_jobs',
	],
	//-- -- -- --
];
