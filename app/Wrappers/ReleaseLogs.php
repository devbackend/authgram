<?php
namespace App\Wrappers;

/**
 * Обёртка для информации о релизе.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ReleaseLogs {
	const RELEASE_STATUS_NEW        = 0;
	const RELEASE_STATUS_PROCESS    = 1;
	const RELEASE_STATUS_FINISHED   = 2;

	/** @var int Статус релиза */
	public $status = self::RELEASE_STATUS_FINISHED;

	/** @var string Содержимое файла composer.log */
	public $composer;

	/** @var string Содержимое файла deploy */
	public $deploy;

	/** @var string Содержимое файла git.log */
	public $git;

	/** @var string Содержимое файла gulp.log */
	public $gulp;

	/** @var string Содержимое файла migrate.log */
	public $migrate;

	/** @var string Содержимое файла yarn.log */
	public $yarn;
}