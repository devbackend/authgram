<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Модель кода авторизации.
 *
 * @property int    $id                 Идентификатор записи
 * @property string $application_uuid   Идентификатор приложения
 * @property int    $code               Код
 * @property string $expired_at         Время устаревания кода
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthCode extends Entity {
	const ID                = 'id';
	const APPLICATION_UUID  = 'application_uuid';
	const CODE              = 'code';
	const EXPIRED_AT        = 'expired_at';

	/** Время устаревания кода авторизации (в секундах) */
	const EXPIRED_TIME_SEC = 900;

	/** @var bool Отключаем автоматические timestamp'ы */
	public $timestamps = false;

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
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function boot() {
		parent::boot();

		static::creating(function($entity) {
			/** @var static $entity */

			$entity->code       = rand(100000, 999999);
			$entity->expired_at = Carbon::now()->addSecond(static::EXPIRED_TIME_SEC)->toDateTimeString();
		});
	}
}