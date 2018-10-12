<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

/**
 * Модель пользователя.
 *
 * @property string $uuid                           Идентификатор пользователя
 * @property int    $telegram_id                    Идентификатор пользователя в Telegram
 * @property string $username                       Никнейм пользователя
 * @property string $first_name                     Имя пользователя
 * @property string $last_name                      Фамилия пользователя
 * @property bool   $notification_enabled           Уведомления включены
 * @property string $profile_photo                  Фото профиля
 * @property bool   $last_message_status            Статус отправки последнего сообщения
 * @property int    $last_message_attempts          Количество попытоу отправки последнего сообщения
 *
 * @property-read Application[] $applications Приложения, добавленные пользователем.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class User extends Entity {
	/** Telegram идентификатор админа сайта */
	const ADMIN_TELEGRAM_ID = 114307233;

	const UUID                  = 'uuid';
	const TELEGRAM_ID           = 'telegram_id';
	const USERNAME              = 'username';
	const FIRST_NAME            = 'first_name';
	const LAST_NAME             = 'last_name';
	const NOTIFICATION_ENABLED  = 'notification_enabled';
	const PROFILE_PHOTO         = 'profile_photo';
	const LAST_MESSAGE_STATUS   = 'last_message_status';
	const LAST_MESSAGE_ATTEMPTS = 'last_message_attempts';

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
			$entity->uuid = Uuid::uuid4();
		});
	}
}
