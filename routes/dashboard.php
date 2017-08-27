<?php

use App\Http\Kernel;
use Illuminate\Routing\Router;

/**
 * Роуты для Админки приложения
 *
 * @var Router $router Роутер приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
//-- Управление приложенями
$router->group(['prefix' => 'apps'], function () use ($router) {
	$router->get('/',                   'ApplicationController@index');
	$router->get('/{uuid}',             'ApplicationController@show');
	$router->put('/{uuid}/update',      'ApplicationController@update');
	$router->delete('/{uuid}/delete',   'ApplicationController@delete');
});
//-- -- -- --

$router->group(['middleware' => [Kernel::MIDDLEWARE_ALIAS_AUTH_ADMIN]], function() use ($router) {
	$router->get('/', 'DashboardController@indexAction');

	$router->group(['prefix' => 'income-messages'], function (Router $router) {
		$router->get('/', 'IncomeMessagesController@indexAction');
	});

	//-- Управление пользователями
	$router->group(['prefix' => 'users'], function () use ($router) {
		$router->get('/',       'UserController@indexAction');
		$router->get('/{uuid}', 'UserController@showAction');
	});
	//-- -- -- --

	// -- Управление уведомлениями
	$router->group(['prefix' => 'notifications'], function() use ($router) {
		$router->get('/',           'NotificationController@indexAction');
		$router->post('/send/test', 'NotificationController@testSendAction');
		$router->post('/send/real', 'NotificationController@realSendAction');
	});
	// -- -- -- --

	// -- Просмотр статистики авторизации
	$router->group(['prefix' => 'auth-statisric'], function() use ($router) {
		$router->get('/', 'AuthStatisticController@indexAction');
	});
	// -- -- -- --
});
