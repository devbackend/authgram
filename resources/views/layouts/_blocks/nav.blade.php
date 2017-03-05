<?php
/**
 * Шаблон блока навигации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Providers\RouteServiceProvider;
?>

<div class="navbar-fixed">
	<nav>
		<div class="container nav-wrapper">
			<a data-scroll-nav="0" href="<?= route(RouteServiceProvider::ROUTE_NAME_HOMEPAGE) ?>" class="brand-logo">
				<i></i>
				<?= env('BOT_NAME') ?>Bot
			</a>
			<ul class="right hide-on-med-and-down">
				<li data-scroll-nav="0" class="active"><a href="javascript:">О сервисе</a></li>
				<li data-scroll-nav="1"><a href="javascript:">Добавить</a></li>
				<li data-scroll-nav="2"><a href="javascript:">Разработчикам</a></li>
			</ul>
		</div>
	</nav>
</div>