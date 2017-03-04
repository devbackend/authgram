<?php
/**
 * Функции для работы деплойера
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

/**
 * Запись в лог
 *
 * @param resource  $handler    ресурс, в который ведётся запись
 * @param string    $logInfo    Содержимое лога
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
function writeToLog($handler, $logInfo) {
	fwrite($handler, '[' . date('Y-m-d H:i:s') . '] ' . $logInfo . PHP_EOL);
}