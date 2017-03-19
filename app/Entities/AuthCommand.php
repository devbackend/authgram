<?php
namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель команды авторизации.
 *
 * @property string $application_uuid   Идентификатор приложения
 * @property string $command            Значение команды авторизации
 * @property string $expired_at         Время устаревания кода
 *
 * @property-read Application $application Приложение, с которорым связана команда авторизации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AuthCommand extends Entity {
	const COMMAND           = 'command';
	const APPLICATION_UUID  = 'application_uuid';
	const EXPIRED_AT        = 'expired_at';

	/** Время устаревания кода авторизации (в секундах) */
	const EXPIRED_TIME_SEC = 59;

	/** @var bool Отключаем автоинкремент для первичного ключа */
	public $incrementing = false;

	/** @var bool Отключаем автоматические timestamp'ы */
	public $timestamps = false;

	/** @var string Первичный ключ */
	protected $primaryKey = self::COMMAND;

	/** @var string[] Названия полей для массового заполнения */
	protected $fillable = [self::APPLICATION_UUID];

	/**
	 * Проверка кода авторизации.
	 * Если код не найден или устарел - возвращает null
	 *
	 * @param string $command код авторизации
	 *
	 * @return static|null
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function check(string $command) {
		$now = Carbon::now()->toDateTimeString();

		$command = static::where(static::COMMAND, $command)->where(static::EXPIRED_AT, '>=', $now)->first();

		return $command;
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
			$entity->command    = 'ag' . strtolower(str_random(2));
			$entity->expired_at = Carbon::now()->addSecond(static::EXPIRED_TIME_SEC)->toDateTimeString();
		});
	}
}