<?php

namespace App\Logger;

use App\Entities\Log;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Обработчик логов.
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
			Log::URL        => $record['extra']['url'],
			Log::IP         => $record['extra']['ip'],
			Log::METHOD     => $record['extra']['method'],
			Log::PARAMS     => $record['extra']['params'],
		]);
	}
}