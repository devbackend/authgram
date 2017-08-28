<?php
namespace App\Entities;

use Auth;
use Gate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

/**
 * Модель приложения.
 *
 * @property string     $uuid                   Идентификатор приложения
 * @property string     $owner_uuid             Идентификатор владельца приложения
 * @property string     $title                  Название приложения
 * @property string     $website                Адрес сайта
 * @property string     $auth_request_url       URL на который будут отправлены данные авторизации пользователя
 * @property string     $api_token              Уникальный токен приложения
 * @property string     $success_auth_message   Сообщение пользователю при успешной авторизации
 *
 * @property-read User $owner Владелец приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Application extends Entity {
	use SoftDeletes;

	const UUID                  = 'uuid';
	const OWNER_UUID            = 'owner_uuid';
	const TOKEN                 = 'token';
	const TITLE                 = 'title';
	const WEBSITE               = 'website';
	const AUTH_REQUEST_URL      = 'auth_request_url';
	const SUCCESS_AUTH_MESSAGE  = 'success_auth_message';

	/** @var bool Отключаем автоинкремент для первичного ключа */
	public $incrementing = false;

	/** @var string Первичный ключ */
	protected $primaryKey = self::UUID;

	protected $fillable = [
		self::TITLE,
		self::WEBSITE,
		self::OWNER_UUID,
		self::AUTH_REQUEST_URL,
		self::SUCCESS_AUTH_MESSAGE,
	];

	protected $dates = [self::DELETED_AT];

	/**
	 * Релейшн с владельцем приложения.
	 *
	 * @return BelongsTo
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function owner() {
		return $this->belongsTo(User::class);
	}
	const RELATION_OWNER = 'owner';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function boot() {
		parent::boot();

		static::creating(function($entity) {
			/** @var static $entity */
			$uuid = Uuid::generate()->string;

			$entity->uuid                   = $uuid;
			$entity->api_token              = static::generateApiToken($uuid);
			$entity->success_auth_message   = "Вы успешно авторизовались.\n\nВернитесь в браузер, чтобы продолжить работу с сайтом.";
		});
	}

	/**
	 * Генерация токена для приложения
	 *
	 * @param string $uuid Идентификатор приложения
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function generateApiToken($uuid) {
		return strtolower(md5($uuid) . str_random(28));
	}

	/**
	 * Приложение доступно для текцщего пользователя.
	 *
	 * @return bool
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function isAvailableForCurrentUser(): bool {
		/** @var Owner $owner */
		$owner = Auth::user();

		return ($this->owner_uuid === $owner->user->uuid
			|| Gate::allows(Policy::ADMIN_ACTION)
		);
	}
}