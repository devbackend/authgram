<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Контролер главной страницы.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class HomepageController extends Controller {
	/**
	 * Реализация основной логики контроллера.
	 *
	 * @param Request $request Входящий запрос
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request) {
		return $this->render('index');
	}
}