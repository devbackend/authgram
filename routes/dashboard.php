<?php

use Illuminate\Routing\Router;

/**
 * Роуты для Админки приложения
 *
 * @var Router $router Роутер приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
$router->get('/', 'DashboardController@indexAction');

$router->group(['prefix' => 'income-messages'], function (Router $router) {
	$router->get('/', 'IncomeMessagesController@indexAction');
});

//-- Управление приложенями
$router->group(['prefix' => 'apps'], function () use ($router) {
	$router->get('/',       'ApplicationController@index');
	$router->get('/{uuid}', 'ApplicationController@show');
});
//-- -- -- --

//-- Управление пользователями
$router->group(['prefix' => 'users'], function () use ($router) {
	$router->get('/',       'UserController@indexAction');
	$router->get('/{uuid}', 'UserController@showAction');
});
//-- -- -- --
