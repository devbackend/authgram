<?php
namespace App\Wrappers\authRequest;

/**
 * Обёртка пользователя для передачи в запросе авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class User {
	/** @var string Идентификатор пользователя */
	public $uuid;

	/** @var string Никнейм пользователя */
	public $username;

	/** @var string Имя пользователя */
	public $firstName;

	/** @var string Фамилия пользователя */
	public $lastName;

	/** @var string URL-адрес фото профиля */
	public $profilePhotoUrl;
}