<?php

namespace App\Entities;

/**
 * Модель для логирования.
 *
 * @property string $guid
 * @property int    $level
 * @property string $message
 * @property string $category
 * @property string $file
 * @property string $trace
 * @property string $insert_stamp
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Log extends Entity {
	const GUID          = 'guid';
	const LEVEL         = 'level';
	const MESSAGE       = 'message';
	const CATEGORY      = 'category';
	const FILE          = 'file';
	const TRACE         = 'trace';
	const INSERT_STAMP  = 'insert_stamp';

	/** @var bool Отключаем автоинкремент для первичного ключа */
	public $incrementing = false;

	/** @var string Первичный ключ */
	protected $primaryKey = self::GUID;

	/** @var string[] Дата удаления */
	protected $dates = [self::DELETED_AT];

	/** @inheritdoc */
	protected $fillable = [
		self::LEVEL,
		self::MESSAGE,
		self::CATEGORY,
		self::FILE,
		self::TRACE,
		self::INSERT_STAMP,
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
	protected static $levels = array(
		self::DEBUG     => 'Отладка',
		self::INFO      => 'Информационное сообщение',
		self::NOTICE    => 'Уведомление',
		self::WARNING   => 'Предупреждение',
		self::ERROR     => 'Ошибка',
		self::CRITICAL  => 'Критическая ошибка',
		self::ALERT     => 'Проблема с доступностью сайта',
		self::EMERGENCY => 'Приоритетная ошибка',
	);
}