<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Роуты для HTTP части приложения
 *
 * @var Router $router Роутер приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$router->any('/', 'HomepageController')->name(RouteServiceProvider::ROUTE_NAME_HOMEPAGE);
$router->get('/p/{slug}', 'PagesController@showAction');

$router->get('telegram', function(){
	Telegram::commandsHandler();
});

$router->post('webhook/{token}', 'WebhookController')->name(RouteServiceProvider::ROUTE_NAME_WEBHOOK);

$router->post('auth/telegram', 'AuthRequestController');

//-- Получение кода авторизации
$router->get('auth/{appUuid}/{callback}', 'AuthController');
$router->get('auth/logout', 'AuthController@logoutAction');
//-- -- -- --

//-- Управление приложениями
$router->post('application', 'ApplicationController@createAction');
$router->delete('application', 'ApplicationController@deleteAction');
//-- -- -- --

//-- Получение данных по релизам
$router->get('releases/getInfo', 'ReleasesController@getInfoAction');
//-- -- -- --