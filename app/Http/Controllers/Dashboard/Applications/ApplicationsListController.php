<?php

namespace App\Http\Controllers\Dashboard\Applications;

use App\Http\Controllers\BackOfficeController;
use App\Repositories\ApplicationRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Logging\Log;

/**
 * Контроллер списка приложений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationsListController extends BackOfficeController {
	/** @var ApplicationRepository */
	private $applications;

	/**
	 * @param Log                   $logger
	 * @param Repository            $cache
	 * @param ApplicationRepository $applications
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(Log $logger, Repository $cache, ApplicationRepository $applications) {
		$this->applications = $applications;

		parent::__construct($logger, $cache);
	}

	/**
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		return $this->render('list', [
			'applications' => $this->applications->getPaginatedApplications(),
		]);
	}
}