<?php
namespace App\Entities;

/**
 * Модель страницы.
 *
 * @property int    $id         Идентификатор страницы
 * @property string $slug       ЧПУ часть адреса
 * @property string $title      Заголовок
 * @property string $content    Содержимое страницы
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Page extends Entity {
	const ID        = 'id';
	const SLUG      = 'slug';
	const TITLE     = 'title';
	const CONTENT   = 'content';
}