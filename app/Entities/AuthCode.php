<?php
namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель кода авторизации.
 *
 * @property int    $id                 Идентификатор записи
 * @property string $application_uuid   Идентификатор приложения
 * @property int    $code               Код
 * @property string $expired_at         Время устаревания кода
 *
 * @property-read Application $application Приложение, с которорым связан код авторизации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthCode extends Entity {
	const CODE              = 'code';
	const APPLICATION_UUID  = 'application_uuid';
	const EXPIRED_AT        = 'expired_at';

	/** Время устаревания кода авторизации (в секундах) */
	const EXPIRED_TIME_SEC = 30;

	/** @var bool Отключаем автоинкремент для первичного ключа */
	public $incrementing = false;

	/** @var bool Отключаем автоматические timestamp'ы */
	public $timestamps = false;

	/** @var string Первичный ключ */
	protected $primaryKey = self::CODE;

	/** @var string[] Названия полей для массового заполнения */
	protected $fillable = [self::APPLICATION_UUID];

	/**
	 * Проверка кода авторизации.
	 * Если код не найден или устарел - возвращает null
	 *
	 * @param int $code код авторизации
	 *
	 * @return static|null
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function check(int $code) {
		$now = Carbon::now()->toDateTimeString();

		$code = static::where(static::CODE, $code)->where(static::EXPIRED_AT, '>=', $now)->first();

		return $code;
	}

	/**
	 * Приложение, с которорым связан код авторизации
	 *
	 * @return BelongsTo
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function application() {
		return $this->belongsTo(Application::class, static::APPLICATION_UUID);
	}
	const RELATION_APPLICATION = 'application';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function boot() {
		parent::boot();

		static::creating(function($entity) {
			/** @var static $entity */

			$entity->code       = rand(1000, 9999);
			$entity->expired_at = Carbon::now()->addSecond(static::EXPIRED_TIME_SEC)->toDateTimeString();
		});
	}
}