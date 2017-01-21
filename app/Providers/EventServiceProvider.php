<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Сервис-провайдер событий внутри приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class EventServiceProvider extends ServiceProvider {
	/** @var array Слушатели событий */
	protected $listen = [];
}
