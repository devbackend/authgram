<?php
namespace App\Entities;

use Eloquent;

/**
 * Базовый класс моделей.
 *
 * @method static $this create(array $fields) Создание модели
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class Entity extends Eloquent {}