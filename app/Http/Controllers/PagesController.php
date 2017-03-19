<?php
namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Контроллер статичных страниц.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class PagesController extends Controller {
	/**
	 * Просмотр страницы.
	 *
	 * @param string $slug ЧПУ-часть адреса
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function showAction($slug) {
		return $this->render('show', ['page' => $slug]);
	}
}