<?php

use App\Entities\Owner;
use App\Http\Controllers\Dashboard\Applications\ApplicationsListController;
use App\Http\Controllers\Dashboard\AuthStatistic\AttemptsController;
use App\Http\Controllers\Dashboard\IncomeMessages\IncomeMessagesController;
use App\Http\Controllers\Dashboard\Logs\LogsListController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\Users\UsersListController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\MessageBag;

/**
 * Каркас страниц панели управления.
 *
 * @var string      $content    Контент страницы
 * @var MessageBag  $errors     Список ошибок
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

/** @var Owner $user */
$user = app(Guard::class)->user();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Панель управления</title>

	<link rel="shortcut icon" href="/favicon.png">
	<link href="/css/back-office.vendors.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
	<div class="main_container">
		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="<?= route('dashboard') ?>" class="site_title">
						<span>Панель управления</span></a>
				</div>

				<div class="clearfix"></div>

				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					<div class="menu_section">
						<ul class="nav side-menu">
							<li>
								<a href="<?= action(UsersListController::class) ?>"><i class="fa fa-user"></i> Пользователи</a>
							</li>

							<li>
								<a href="<?= action(ApplicationsListController::class) ?>"><i class="fa fa-server"></i> Приложения</a>
							</li>

							<li>
								<a href="<?= action(IncomeMessagesController::class) ?>"><i class="fa fa-envelope-o"></i> Сообщения</a>
							</li>

							<li>
								<a href="<?= action(NotificationController::class . '@indexAction') ?>"><i class="fa fa-pencil"></i> Рассылка</a>
							</li>

							<li>
								<a href="<?= action(AttemptsController::class) ?>"><i class="fa fa-area-chart"></i> Статистика авторизации</a>
							</li>

							<li>
								<a href="<?= action(LogsListController::class) ?>"><i class="fa fa-code"></i> Логи</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- top navigation -->
		<div class="top_nav">
			<div class="nav_menu">
				<nav class="" role="navigation">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>

					<ul class="nav navbar-nav navbar-right">
						<li class="">
							<a href="javascript:" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<?= $user->user->getName() ?>
								<span class=" fa fa-angle-down"></span>
							</a>
							<ul class="dropdown-menu dropdown-usermenu pull-right">
								<li><a href="<?= route('logout') ?>"><i class="fa fa-sign-out pull-right"></i> Выйти</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- /top navigation -->

		<!-- page content -->
		<div class="right_col" role="main">
			<?php if (true === $errors->any()): ?>
				<div class="row">
					<div class="col-md-offset-2 col-md-9">
						<?php foreach ($errors->all() as $error): ?>
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
								<?= $error ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>

			<?= $content ?>
		</div>
		<!-- /page content -->

		<!-- footer content -->
		<footer>
			<div class="pull-right">

			</div>
			<div class="clearfix"></div>
		</footer>
		<!-- /footer content -->
	</div>
</div>

<script type="text/javascript" src="/js/back-office.vendors.js"></script>
<script type="text/javascript" src="/js/back-office.app.js"></script>
</body>
</html>