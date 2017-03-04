<?php
/**
 * Команды, которые необходимо выполнять при деплое приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

require "deployer/functions.php";

//-- Создаём папку, в которой будут храниться данные по текущему релизу
$releaseDir = __DIR__ . '/releases/' . date('Y-m-d-H-i-s');
@mkdir($releaseDir, 0755);
//-- -- -- --

$deployHandler = fopen($releaseDir . '/deploy.log', 'w');

writeToLog($deployHandler, 'Начало деплоя');

//-- Пытаемся обработать данные вебхука
$webhookRequest = @file_get_contents('php://input');
if ('' === $webhookRequest) {
	writeToLog($deployHandler, 'Не удалось получить данные вебхука. Остановка деплоя');
	fclose($deployHandler);

	exit;
}

// сохраняем содержимое payload'а
file_put_contents($releaseDir . '/payload.json', $webhookRequest);

/*$webhookRequest = @json_decode($webhookRequest);
if (null === $webhookRequest) {
	writeToLog($deployHandler, 'Не удалось распарсить данные вебхука. Остановка деплоя');
	fclose($deployHandler);

	exit;
}*/
//-- -- -- --

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
shell_exec('/usr/bin/php ' . __DIR__ . '/../artisan migrate >> ' . $releaseDir . '/migrate.log');
writeToLog($deployHandler, 'Завершение выполнения миграций');

writeToLog($deployHandler, 'Сборка фронтенда');
shell_exec('/usr/local/bin/gulp --production >> ' . $releaseDir . '/gulp.log');
writeToLog($deployHandler, 'Завершение сборки фронтенда');

writeToLog($deployHandler, 'Завершение деплоя');