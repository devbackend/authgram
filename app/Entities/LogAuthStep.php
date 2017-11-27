<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Модель логирования шагов авторизации.
 *
 * @property string $guid
 * @property string $attempt_guid
 * @property string $application_uuid
 * @property string $user_uuid
 * @property int    $step
 * @property string $command
 * @property string $message
 * @property Carbon $insert_stamp
 *
 * @property-read Application   $application
 * @property-read User          $user
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogAuthStep extends Entity {
	const GUID              = 'guid';
	const ATTEMPT_GUID      = 'attempt_guid';
	const STEP              = 'step';
	const APPLICATION_UUID  = 'application_uuid';
	const USER_UUID         = 'user_uuid';
	const COMMAND           = 'command';
	const MESSAGE           = 'message';
	const INSERT_STAMP      = 'insert_stamp';

	/** Константа шага: запрос на авторизацию */
	const STEP_GET_CODE     = 0;
	/** Константа шага: отправка команды боту */
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

	public $timestamps = false;

	public $incrementing = false;

	protected $primaryKey = self::GUID;

	protected $dates = [
		self::INSERT_STAMP
	];

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
	 * @return HasOne
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function application() {
		return $this->hasOne(Application::class, Application::UUID, static::APPLICATION_UUID);
	}

	/**
	 * @return HasOne
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function user() {
		return $this->hasOne(User::class, User::UUID, static::USER_UUID);
	}
}