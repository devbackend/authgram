<?php

use Illuminate\Routing\Router;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Роуты для HTTP части приложения
 *
 * @var Router $router Роутер приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$router->any('/', 'HomepageController');

$router->get('telegram', function(){
	Telegram::commandsHandler();
});