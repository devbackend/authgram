<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Telegram\Bot\Objects\User as TelegramUser;
use Uuid;

/**
 * Модель пользователя.
 *
 * @property string $uuid                   Идентификатор пользователя
 * @property int    $telegram_id            Идентификатор пользователя в Telegram
 * @property string $username               Никнейм пользователя
 * @property string $first_name             Имя пользователя
 * @property string $last_name              Фамилия пользователя
 * @property bool   $notification_enabled   Уведомления включены
 *
 * @property-read Application[] $applications Приложения, добавленные пользователем.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class User extends Entity {
	/** Telegram идентификатор админа сайта */
	const ADMIN_TELEGRAM_ID = 114307233;

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
	 * @return User
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function loadByTelegramProfile(TelegramUser $telegramUser): User {
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
	 * Получение отображаемого имени пользователя.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getName() {
		return ('' !== $this->username ? $this->username : $this->first_name);
	}

	/**
	 * Приложения, добавленные пользователем.
	 *
	 * @return HasMany
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function applications() {
		return $this->hasMany(Application::class, Application::OWNER_UUID, static::UUID);
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