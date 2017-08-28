<?php

use App\Entities\Application;use App\Entities\LogIncomeMessage;use App\Entities\User;use App\Repositories\DashboardStatisticRepository;

/**
 * Шаблон для главной страницы панели управления.
 *
 * @var DashboardStatisticRepository $statisticRepository
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="col s4">
			<h2>Пользователи</h2>
			<p><b>Всего:</b> <?= $statisticRepository->getEntityTotalCount(User::class) ?></p>
			<p><b>За последние 24 часа:</b> <?= $statisticRepository->getCountByHourPeriod(User::class) ?></p>

			<a href="<?= action('Dashboard\UserController@indexAction') ?>" target="_blank">Перейти</a>
		</div>

		<div class="col s4">
			<h2>Приложения</h2>
			<p><b>Всего:</b> <?= $statisticRepository->getEntityTotalCount(Application::class) ?></p>
			<p><b>За последние 24 часа:</b> <?= $statisticRepository->getCountByHourPeriod(Application::class) ?></p>

			<a href="<?= action('Dashboard\ApplicationController@index') ?>" target="_blank">Перейти</a>
		</div>

		<div class="col s4">
			<h2>Собщения</h2>
			<p><b>Всего:</b> <?= $statisticRepository->getEntityTotalCount(LogIncomeMessage::class) ?></p>
			<p><b>За последние 24 часа:</b> <?= $statisticRepository->getCountByHourPeriod(LogIncomeMessage::class) ?></p>

			<a href="<?= action('Dashboard\IncomeMessagesController@indexAction') ?>" target="_blank">Перейти</a>
		</div>
	</div>

	<div class="row">
		<div class="col s6">
			<a href="<?= action('Dashboard\AuthStatisticController@indexAction') ?>" target="_blank">Статистика авторизаций</a>
			<br>
			<a href="<?= action('Dashboard\NotificationController@indexAction') ?>" target="_blank">Рассылка</a>
		</div>
	</div>
@endsection