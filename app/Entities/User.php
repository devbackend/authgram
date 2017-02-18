<?php

namespace App\Entities;

use Telegram\Bot\Objects\User as TelegramUser;
use Uuid;

/**
 * Модель пользователя.
 *
 * @property string $uuid           Идентификатор пользователя
 * @property int    $telegram_id    Идентификатор пользователя в Telegram
 * @property string $username       Никнейм пользователя
 * @property string $first_name     Имя пользователя
 * @property string $last_name      Фамилия пользователя
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class User extends Entity {
	const UUID          = 'uuid';
	const TELEGRAM_ID   = 'telegram_id';
	const USERNAME      = 'username';
	const FIRST_NAME    = 'first_name';
	const LAST_NAME     = 'last_name';

	/** @var bool Отключаем автоинкремент для первичного ключа */
	public $incrementing = false;

	/** @var string Первичный ключ */
	protected $primaryKey = self::UUID;

	protected $fillable = [
		self::TELEGRAM_ID,
		self::USERNAME,
		self::FIRST_NAME,
		self::LAST_NAME,
	];

	/**
	 * Загрузка пользователя по его профилю Telegram.
	 *
	 * @param TelegramUser $telegramUser Профиль в telegram
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function loadByTelegramProfile(TelegramUser $telegramUser) {
		$telegramId = $telegramUser->getId();

		$user = static::where(static::TELEGRAM_ID, $telegramId)->first();
		if (null === $user) {
			$user = User::create([
				User::TELEGRAM_ID   => $telegramId,
				User::USERNAME      => $telegramUser->getUsername()     ?? '',
				User::FIRST_NAME    => $telegramUser->getFirstName()    ?? '',
				User::LAST_NAME     => $telegramUser->getLastName()     ?? '',
			]);
		}

		return $user;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function boot() {
		parent::boot();

		static::creating(function($entity) {
			$entity->uuid = Uuid::generate()->string;
		});
	}
}