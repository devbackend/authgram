<?php

use App\Entities\Application;use App\Entities\LogAuthAttemptTmp;use App\Entities\LogIncomeMessage;use App\Entities\User;use App\Repositories\DashboardStatisticRepository;

/**
 * Шаблон для главной страницы панели управления.
 *
 * @var DashboardStatisticRepository $statisticRepository
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$authStepTitles = LogAuthAttemptTmp::getStepTitles();
$authSteps      = array_keys($authStepTitles);

?>

@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="col s4">
			<h2>Пользователи</h2>
			<p><b>Всего:</b> <?= $statisticRepository->getEntityCount(User::class) ?></p>
			<p><b>За последние 24 часа:</b> <?= $statisticRepository->getEntityCount(User::class, 24) ?></p>

			<a href="<?= action('Dashboard\UserController@indexAction') ?>">Перейти</a>
		</div>

		<div class="col s4">
			<h2>Приложения</h2>
			<p><b>Всего:</b> <?= $statisticRepository->getEntityCount(Application::class) ?></p>
			<p><b>За последние 24 часа:</b> <?= $statisticRepository->getEntityCount(Application::class, 24) ?></p>

			<a href="<?= action('Dashboard\ApplicationController@index') ?>">Перейти</a>
		</div>

		<div class="col s4">
			<h2>Собщения</h2>
			<p><b>Всего:</b> <?= $statisticRepository->getEntityCount(LogIncomeMessage::class) ?></p>
			<p><b>За последние 24 часа:</b> <?= $statisticRepository->getEntityCount(LogIncomeMessage::class, 24) ?></p>

			<a href="<?= action('Dashboard\IncomeMessagesController@indexAction') ?>">Перейти</a>
		</div>
	</div>

	<div class="row">
		<div class="col s12">
			<h2>Авторизация</h2>

			<table class="bordered">
				<tr>
					<th>Период</th>
					<?php foreach ($authStepTitles as $stepTitle): ?>
						<th><?= $stepTitle ?></th>
					<?php endforeach ?>
				</tr>

				<?php foreach ([0 => 'Всё время', 24 => '24 часа'] as $period => $title): ?>
					<tr>
						<?php $attempts = $statisticRepository->getAuthStepsStatistic($period); ?>

						<td><b><?= $title ?></b></td>
						<?php foreach ($authSteps as $step): ?>
							<td><?= (true === array_key_exists($step, $attempts) ? $attempts[$step] : 0) ?></td>
						<?php endforeach ?>
					</tr>
				<?php endforeach ?>
			</table>

			<p>
				<a href="<?= action('Dashboard\AuthStatisticController@indexAction') ?>">Перейти</a>
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col s6">
			<p>
				<a href="<?= action('Dashboard\NotificationController@indexAction') ?>">Рассылка</a>
			</p>

			<p>
				<a href="<?= action('Dashboard\LogsController@indexAction') ?>">Логи</a>
			</p>
		</div>
	</div>
@endsection