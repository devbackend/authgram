<?php

use Illuminate\Routing\Router;

/**
 * Группа роутов для API запросов к приложению
 *
 * @var Router $router Роутер HTTP запросов
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$router->group(['middleware' => ['auth:api'], 'prefix' => 'v1', 'namespace' => 'Api\v1'], function() use ($router) {

});
