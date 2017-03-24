<?php
namespace App\Entities;

/**
 * Модель команды авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthCommand {
	/** Время устаревания кода авторизации (в секундах) */
	const EXPIRED_TIME_SEC = 59;

	/** Константа для префикса названия ключа кэша */
	const CACHE_KEY_NAME_PREFIX = 'authorisation-command';

	/** @var string Идентификатор приложения */
	public $applicationUuid;

	/** @var string Значение команды авторизации */
	public $command;

	/**
	 * Генерация команды.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function generateCommandName() {
		return 'ag' . strtolower(str_random(2));
	}

	/**
	 * Получение ключа для кэширования команды.
	 *
	 * @param string $commandName Название команды
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function getKeyName($commandName) {
		return AuthCommand::CACHE_KEY_NAME_PREFIX . '-' . $commandName;
	}
}