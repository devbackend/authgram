<?php
namespace App\Wrappers\authRequest;

/**
 * Обёртка для отправки запроса с авторизационными данными пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Request {
	/** @var string Токен приложения */
	public $token;

	/** @var string Ключ авторизации пользователя */
	public $authKey;

	/** @var User Данные пользователя */
	public $user;
}