<?php

namespace App\Http\Controllers\Dashboard\AuthStatistic;

use App\Entities\LogAuthStep;
use App\Http\Controllers\BackOfficeController;
use App\Repositories\LogAuthStepRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Контроллер статистики авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class AttemptsController extends BackOfficeController {
	/** Лимит записей на страницу */
	const PAGINATION_LIMIT = 50;

	/** @var LogAuthStepRepository */
	protected $authStepRepository;

	/**
	 * @param Log                   $logger
	 * @param Repository            $cache
	 * @param LogAuthStepRepository $authStepRepository
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(Log $logger, Repository $cache, LogAuthStepRepository $authStepRepository) {
		$this->authStepRepository = $authStepRepository;

		parent::__construct($logger, $cache);
	}

	/**
	 * Главная страница.
	 *
	 * @param Request $request
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request) {
		$steps = $request->input('step', []);

		$attempts = $this->authStepRepository->getLastAttempts(static::PAGINATION_LIMIT, $steps);

		$attemptGuids = [];
		foreach ($attempts as $attempt) {/** @var LogAuthStep $attempt */
			$attemptGuids[] = $attempt->attempt_guid;
		}

		$authSteps = $this->authStepRepository->getAuthStepsByAttemptIds($attemptGuids);

		return $this->render('index', [
			'attempts'  => $attempts,
			'authSteps' => $authSteps,
			'checked'   => $steps,
		]);
	}
}