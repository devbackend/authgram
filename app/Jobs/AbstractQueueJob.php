<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Базовый класс задач для очередей.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class AbstractQueueJob implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Обработка задачи.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	abstract public function handle();
}