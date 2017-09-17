<?php

namespace App\Entities;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Модель для логирования.
 *
 * @property string     $guid
 * @property int        $level
 * @property string     $category
 * @property string     $message
 * @property string     $file
 * @property string[]   $trace
 * @property string     $url
 * @property string     $ip
 * @property string     $method
 * @property string[]   $params
 * @property Carbon     $insert_stamp
 * @property Carbon     $deleted_at
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Log extends Entity {
	const GUID          = 'guid';
	const LEVEL         = 'level';
	const CATEGORY      = 'category';
	const MESSAGE       = 'message';
	const FILE          = 'file';
	const TRACE         = 'trace';
	const INSERT_STAMP  = 'insert_stamp';
	const URL           = 'url';
	const IP            = 'ip';
	const METHOD        = 'method';
	const PARAMS        = 'params';

	/** @var bool Отключаем автоинкремент для первичного ключа */
	public $incrementing = false;

	/** @var string Первичный ключ */
	protected $primaryKey = self::GUID;

	/** @var string[] Дата удаления */
	protected $dates = [self::INSERT_STAMP, self::DELETED_AT];

	/** @inheritdoc */
	protected $fillable = [
		self::LEVEL,
		self::MESSAGE,
		self::CATEGORY,
		self::FILE,
		self::TRACE,
		self::INSERT_STAMP,
		self::URL,
		self::IP,
		self::METHOD,
		self::PARAMS,
	];

	public $timestamps = false;

	/** Код уровня логирования: отладка */
	const DEBUG     = 100;
	/** Код уровня логирования: информационное сообщение */
	const INFO      = 200;
	/** Код уровня логирования: уведомление */
	const NOTICE    = 250;
	/** Код уровня логирования: предупреждение */
	const WARNING   = 300;
	/** Код уровня логирования: ошибка */
	const ERROR     = 400;
	/** Код уровня логирования: критическая ошибка */
	const CRITICAL  = 500;
	/** Код уровня логирования: проблема с доступностью сайта */
	const ALERT     = 550;
	/** Код уровня логирования: приоритетная ошибка */
	const EMERGENCY = 600;

	/** @var string[] Описание кодов логирования */
	protected static $_levels = array(
		self::DEBUG     => 'Отладка',
		self::INFO      => 'Информационное сообщение',
		self::NOTICE    => 'Уведомление',
		self::WARNING   => 'Предупреждение',
		self::ERROR     => 'Ошибка',
		self::CRITICAL  => 'Критическая ошибка',
		self::ALERT     => 'Проблема с доступностью сайта',
		self::EMERGENCY => 'Приоритетная ошибка',
	);

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected static function boot() {
		parent::boot();

		static::creating(function($entity) {
			$entity->guid = Uuid::uuid4();
		});
	}

	/**
	 * Получение заголовка уровня логов.
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getLevelTitle(): string {
		return (array_key_exists($this->level, static::$_levels)
			? static::$_levels[$this->level]
			: 'Unknown'
		);
	}

	/**
	 * Форматирование значения стека вызова
	 *
	 * @param string $trace
	 *
	 * @return string[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getTraceAttribute(string $trace) {
		return explode("\n", $trace);
	}

	/**
	 * Получение значения аттрибута "Параметры"
	 *
	 * @param string $value
	 *
	 * @return string[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getParamsAttribute(string $value) {
		return json_decode($value);
	}

	/**
	 * Установка аттрибута "Параметры"
	 *
	 * @param array $value
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setParamsAttribute(array $value) {
		$this->attributes[static::PARAMS] = json_encode($value);
	}
}