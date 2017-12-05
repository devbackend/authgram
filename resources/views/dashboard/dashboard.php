<?php

use App\Entities\Application;
use App\Entities\LogAuthStep;
use App\Entities\LogIncomeMessage;
use App\Entities\User;
use App\Repositories\DashboardStatisticRepository;

/**
 * Шаблон для главной страницы панели управления.
 *
 * @var DashboardStatisticRepository $statisticRepository
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$authStepTitles = LogAuthStep::getStepTitles();
$authSteps      = array_keys($authStepTitles);

?>

<h1>Панель управления</h1>

<!-- top tiles -->
<div class="row tile_count">
	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top">
			<i class="fa fa-user"></i> Пользователи
		</span>
		<div class="count">
			<?= $statisticRepository->getEntityCount(User::class) ?>
		</div>
		<span class="count_bottom">
			<?= $statisticRepository->getEntityCount(User::class, 24) ?> за последние 24 часа
		</span>
	</div>

	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top">
			<i class="fa fa-server"></i> Приложения
		</span>
		<div class="count">
			<?= $statisticRepository->getEntityCount(Application::class) ?>
		</div>
		<span class="count_bottom">
			<?= $statisticRepository->getEntityCount(Application::class, 24) ?> за последние 24 часа
		</span>
	</div>

	<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top">
			<i class="fa fa-envelope-o"></i> Сообщения
		</span>
		<div class="count">
			<?= $statisticRepository->getEntityCount(LogIncomeMessage::class) ?>
		</div>
		<span class="count_bottom">
			<?= $statisticRepository->getEntityCount(LogIncomeMessage::class, 24) ?> за последние 24 часа
		</span>
	</div>
</div>
<!-- /top tiles -->

<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Пользователи/Сообщения</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<canvas id="users-and-messages"></canvas>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Статистика авторизаций</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content2">
				<div id="auth-stat" style="width:100%; height:300px;"></div>
			</div>
		</div>
	</div>
</div>

<script>
	window.charts = {};

	window.charts.usersAndMessages  = <?= json_encode($statisticRepository->getUsersAndMessagesChart()) ?>;
	window.charts.authStats         = <?= json_encode($statisticRepository->getAuthStatisticChart()) ?>;
</script>