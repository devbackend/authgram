<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Модель для логгирования авторизации
 *
 * @property int    $id                 Идентификатор записи
 * @property int    $step               Шаг логгирования
 * @property string $application_uuid   Идентификатор приложения
 * @property string $user_uuid          Идентификатор пользователя
 * @property string $command            Значение команды авторизации
 * @property string $additional_info    Дополнительные данные
 * @property string $insert_stamp       Время добавления записи
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogAuthAttempt extends Entity {
	const ID                = 'id';
	const STEP              = 'step';
	const APPLICATION_UUID  = 'application_uuid';
	const USER_UUID         = 'user_uuid';
	const COMMAND           = 'command';
	const ADDITIONAL_INFO   = 'additional_info';
	const INSERT_STAMP      = 'insert_stamp';

	/** Константа шага: получен запрос на авторизацию */
	const STEP_GET_CODE     = 0;
	/** Константа шага: получена команда */
	const STEP_GET_COMMAND  = 1;
	/** Константа шага: авторизация провалена */
	const STEP_AUTH_FAIL    = 2;
	/** Константа шага: авторизация завершилась успешно */
	const STEP_AUTH_SUCCESS = 3;

	/** @inheritdoc */
	protected $fillable = [self::STEP, self::APPLICATION_UUID, self::USER_UUID, self::COMMAND, self::ADDITIONAL_INFO];

	/** @var bool Отключаем автоматические timestamp'ы */
	public $timestamps = false;

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function boot() {
		parent::boot();

		static::creating(function($entity) {
			/** @var static $entity */
			$entity->insert_stamp = Carbon::now()->toDateTimeString();
		});

		static::saving(function($entity) {
			/** @var static $entity */
			if (null === $entity->additional_info) {
				$entity->additional_info = json_encode([]);
			}
		});
	}
}