<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthRequestController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\WebhookController;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;

/**
 * Роуты для HTTP части приложения
 *
 * @var Router $router Роутер приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$router->any('/',           HomepageController  ::class)->name(RouteServiceProvider::ROUTE_NAME_HOMEPAGE);
$router->get('/p/{slug}',   PagesController     ::class . '@showAction');
$router->get('/sign',       DashBoardController ::class . '@signAction')->name(RouteServiceProvider::ROUTE_NAME_SIGN);

$router->get('webhook/dev',      WebhookController::class . '@devAction');
$router->post('webhook/{token}', WebhookController::class)->name(RouteServiceProvider::ROUTE_NAME_WEBHOOK);

$router->post('auth/telegram', AuthRequestController::class);

//-- Получение кода авторизации
$router->get('auth/{appUuid}/{callback}',   AuthController::class);
$router->get('auth/logout',                 AuthController::class . '@logoutAction')->name('logout');
//-- -- -- --

//-- Управление приложениями
$router->post('application',    ApplicationController::class . '@createAction');
$router->delete('application',  ApplicationController::class . '@deleteAction');
//-- -- -- --

//-- Управление приложенями
$router->group(['prefix' => 'apps'], function () use ($router) {
	$router->get('/',                   ApplicationController::class . '@index');
	$router->get('/{uuid}',             ApplicationController::class . '@show');
	$router->put('/{uuid}/update',      ApplicationController::class . '@update');
	$router->delete('/{uuid}/delete',   ApplicationController::class . '@delete');
});
//-- -- -- --