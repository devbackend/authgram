<?php
namespace App\Wrappers;

/**
 * Обёртка для JSON-ответа.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class JsonResponseWrapper {
	/** @var bool Статус выполнения запроса */
	public $status  = false;

	/** @var string[] Данные в формате [ключ => значение] */
	public $data    = [];

	/** @var string Текст собщения */
	public $text    = '';

	/** @var string HTML-контент */
	public $html    = '';
}