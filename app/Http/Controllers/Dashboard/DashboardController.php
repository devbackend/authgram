<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardStatisticRepository;
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
	 * @param DashboardStatisticRepository $statisticRepository
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function indexAction(DashboardStatisticRepository $statisticRepository) {
		return $this->render('index', ['statisticRepository' => $statisticRepository]);
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