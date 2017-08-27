<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Контроллер главной страницы админки.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DashboardController extends Controller {
	/**
	 * Главная страница админки.
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function indexAction() {
		return $this->render('index');
	}

	/**
	 * Страница авторизации.
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function signAction() {
		return $this->render('sign');
	}
}