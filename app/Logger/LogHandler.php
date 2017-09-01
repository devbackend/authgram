<?php

namespace App\Logger;

use App\Entities\Log;
use Monolog\Handler\AbstractProcessingHandler;

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogHandler extends AbstractProcessingHandler {
	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function write(array $record) {
		Log::create([
			Log::LEVEL      => $record['level'],
			Log::MESSAGE    => $record['message'],
			Log::TRACE      => $record['context']['trace']      ?? '',
			Log::FILE       => $record['context']['file']       ?? '',
			Log::CATEGORY   => $record['context']['category']   ?? 'DefaultLogCategory',
		]);
	}
}