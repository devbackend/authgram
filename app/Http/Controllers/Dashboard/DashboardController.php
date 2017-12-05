<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\DashboardStatisticRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Logging\Log;
use Illuminate\View\View;

/**
 * Контроллер главной страницы админки.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class DashboardController extends BackOfficeController {
	/** @var DashboardStatisticRepository */
	private $statisticRepository;

	/**
	 * @param Log                          $logger
	 * @param Repository                   $cache
	 * @param DashboardStatisticRepository $statisticRepository
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(Log $logger, Repository $cache, DashboardStatisticRepository $statisticRepository) {
		$this->statisticRepository = $statisticRepository;

		parent::__construct($logger, $cache);
	}

	/**
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		return $this->render('index', ['statisticRepository' => $this->statisticRepository]);
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