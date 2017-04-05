<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\ApplicationRepository;
use App\Repositories\IncomeMessageRepository;
use App\Repositories\UserRepository;
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
		$users          = resolve(UserRepository::class)->getLastRecords();
		$applications   = resolve(ApplicationRepository::class)->getLastRecords();
		$incomeMessages = resolve(IncomeMessageRepository::class)->getLastRecords();

		return $this->render('index', [
			'users'             => $users,
			'applications'      => $applications,
			'incomeMessages'    => $incomeMessages,
		]);
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