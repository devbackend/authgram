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
			<a href="" class="hide-on-large-only mobile-menu" data-activates="slide-out" data-role="mobile-menu">
				<i class="large material-icons">view_headline</i>
			</a>
			<a href="<?= route(RouteServiceProvider::ROUTE_NAME_HOMEPAGE) ?>" class="brand-logo">
				{{--<i></i>--}}
				<?= env('BOT_NAME') ?>Bot
			</a>
			<ul id="slide-out" class="side-nav">
				<li><a href="<?= route(RouteServiceProvider::ROUTE_NAME_HOMEPAGE) ?>">Главная</a></li>
				<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'add']) ?>">Добавить</a></li>
				<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'dev']) ?>">Разработчикам</a></li>
			</ul>

			<ul class="right hide-on-med-and-down">
				<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'add']) ?>">Добавить</a></li>
				<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'dev']) ?>">Разработчикам</a></li>
			</ul>
		</div>
	</nav>
</div>