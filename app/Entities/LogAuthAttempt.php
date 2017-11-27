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
 * @property-read Application   $application
 * @property-read User          $user
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

	protected static $_stepTitles = [
		self::STEP_GET_CODE     => 'Получен запрос на авторизацию',
		self::STEP_GET_COMMAND  => 'Получена команда',
		self::STEP_AUTH_FAIL    => 'Авторизация не прошла',
		self::STEP_AUTH_SUCCESS => 'Авторизация успешно завершена',
	];

	/** @inheritdoc */
	protected $fillable = [self::STEP, self::APPLICATION_UUID, self::USER_UUID, self::COMMAND, self::ADDITIONAL_INFO];

	/** @var bool Отключаем автоматические timestamp'ы */
	public $timestamps = false;

	protected $table = 'log_auth_attempt_tmp';

	/**
	 * Получение шагов авторизации.
	 *
	 * @return string[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public static function getStepTitles(): array {
		return self::$_stepTitles;
	}

	/**
	 * Получение названия шага.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getStepTitle(): string {
		return static::$_stepTitles[$this->step];
	}

	/**
	 * Получение информации шага.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getStepInfo(): string {
		if (static::STEP_AUTH_FAIL === $this->step) {
			$info = json_decode($this->additional_info);

			return $info->reason;
		}

		return '';
	}

	/**
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function application() {
		return $this->hasOne(Application::class, Application::UUID, static::APPLICATION_UUID);
	}

	/**
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function user() {
		return $this->hasOne(User::class, User::UUID, static::USER_UUID);
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