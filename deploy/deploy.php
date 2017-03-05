<?php
/**
 * Команды, которые необходимо выполнять при деплое приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

require "deployer/functions.php";
$releasesList = __DIR__ . '/releases/';

// Псевдобесконечный цикл
while(time() < PHP_INT_MAX) {
	$releases = scandir($releasesList);
	foreach ($releases as $release) {
		$releaseDir = $releasesList . $release;

		if ('.' === $release || '..' === $release || false === is_dir($releaseDir)) {
			continue;
		}

		$isNew = in_array('.new', scandir($releaseDir));
		if (false === $isNew) {
			continue;
		}

		rename($releaseDir . '/.new', $releaseDir . '/.process');

		$deployHandler = fopen($releaseDir . '/deploy.log', 'w');

		writeToLog($deployHandler, 'Начало деплоя');

		chdir(__DIR__ . '/..');

		writeToLog($deployHandler, 'Выполнение git pull');
		shell_exec('/usr/bin/git pull >> ' . $releaseDir . '/git.log');
		writeToLog($deployHandler, 'Выполнен git pull');

		writeToLog($deployHandler, 'Установка зависимостей Composer');
		shell_exec('/usr/bin/composer install >> ' . $releaseDir . '/composer.log');
		writeToLog($deployHandler, 'Завершение установки зависимостей Composer');

		writeToLog($deployHandler, 'Установка зависимостей Yarn');
		shell_exec('/usr/local/bin/yarn install >> ' . $releaseDir . '/yarn.log');
		writeToLog($deployHandler, 'Завершение установки зависимостей Yarn');

		writeToLog($deployHandler, 'Выполнение миграций');
		shell_exec('/usr/bin/php ' . __DIR__ . '/../artisan migrate --force >> ' . $releaseDir . '/migrate.log');
		writeToLog($deployHandler, 'Завершение выполнения миграций');

		writeToLog($deployHandler, 'Сборка фронтенда');
		shell_exec('/usr/local/bin/gulp --production >> ' . $releaseDir . '/gulp.log');
		writeToLog($deployHandler, 'Завершение сборки фронтенда');

		writeToLog($deployHandler, 'Завершение деплоя');

		unlink($releaseDir . '/.process');
	}

	sleep(5);
}
exit;