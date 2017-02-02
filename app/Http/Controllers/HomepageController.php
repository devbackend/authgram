<?php
namespace App\Http\Controllers;

/**
 * Контролер главной страницы.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class HomepageController extends Controller {
	/**
	 * Реализация основной логики контроллера.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		return $this->render('index');
	}
}