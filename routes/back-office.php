<?php

use App\Http\Controllers\Dashboard\Applications\ApplicationsListController;
use App\Http\Controllers\Dashboard\AuthStatistic\AttemptsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\IncomeMessages\IncomeMessagesController;
use App\Http\Controllers\Dashboard\Logs\DeleteByContentController;
use App\Http\Controllers\Dashboard\Logs\DeleteSelectedController;
use App\Http\Controllers\Dashboard\Logs\LogsListController;
use App\Http\Controllers\Dashboard\Logs\ShowLogController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\Users\UserPageController;
use App\Http\Controllers\Dashboard\Users\UsersListController;
use Illuminate\Routing\Router;

/**
 * Роуты панели управления.
 *
 * @var Router $router
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$router->get('/', DashboardController::class)->name('dashboard');

//-- Управление пользователями
$router->group(['prefix' => 'users'], function () use ($router) {
	$router->get('/',       UsersListController ::class);
	$router->get('/{uuid}', UserPageController  ::class);
});
//-- -- -- --

// -- Просмотр логов
$router->group(['prefix' => 'logs'], function() use ($router) {
	$router->get('/',                   LogsListController          ::class);
	$router->get('/{guid}',             ShowLogController           ::class);
	$router->delete('/delete-selected', DeleteSelectedController    ::class);
	$router->delete('/delete-content',  DeleteByContentController   ::class);
});
// -- -- -- --

$router->group(['prefix' => 'income-messages'], function (Router $router) {
	$router->get('/', IncomeMessagesController::class);
});

// -- Управление уведомлениями
$router->group(['prefix' => 'notifications'], function() use ($router) {
	$router->get('/',           NotificationController::class . '@indexAction');
	$router->post('/send/test', NotificationController::class . '@testSendAction');
	$router->post('/send/real', NotificationController::class . '@realSendAction');
});
// -- -- -- --

// -- Просмотр статистики авторизации
$router->group(['prefix' => 'auth-statistic'], function() use ($router) {
	$router->get('/', AttemptsController::class);
});
// -- -- -- --

// -- Просмотр приложений
$router->group(['prefix' => 'apps'], function() use ($router) {
	$router->get('/', ApplicationsListController::class);
});
// -- -- -- --