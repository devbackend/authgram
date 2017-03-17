<?php
/**
 * Шаблон блока навигации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Page;use App\Providers\RouteServiceProvider;
?>

<div class="navbar-fixed">
	<nav>
		<div class="container nav-wrapper">
			<a href="<?= route(RouteServiceProvider::ROUTE_NAME_HOMEPAGE) ?>" class="brand-logo">
				{{--<i></i>--}}
				<?= env('BOT_NAME') ?>Bot
			</a>
			<ul class="right hide-on-med-and-down">
				<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'add']) ?>">Добавить</a></li>
				<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'dev']) ?>">Разработчикам</a></li>
			</ul>
		</div>
	</nav>
</div>