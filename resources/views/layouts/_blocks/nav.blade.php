<?php
/**
 * Шаблон блока навигации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Owner;use App\Entities\Page;use App\Providers\RouteServiceProvider;

/** @var Owner $currentUser */
$currentUser = Auth::user();
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
				<li class="user-profile">
					<?php if (null !== $currentUser): ?>
						<a href="javascript:" data-activates="profile-menu">
							<i class="material-icons">perm_identity</i>
							<?=
								$currentUser->user->getShowName()
							?>
						</a>

						<ul id='profile-menu' class='dropdown-content'>
							<li><a href="<?= action('PagesController@showAction', [Page::SLUG => 'add']) ?>">Добавить сайт</a></li>
							<li class="divider"></li>
							<li><a href="<?= action('AuthController@logoutAction') ?>">Выйти</a></li>
						</ul>
					<?php else: ?>
						<a href="javascript:" data-role="authgram-sign-button">Войти</a>
						@push('scripts')
						<script type="text/javascript" src="<?= env('API_URL') ?>/js/authgram-widget.js"></script>
						<script type="text/javascript">
							new AuthGramWidget('157bb070-eaee-11e6-84e2-0f2ab592a536', {
								onAuthSuccess: function (authKey) {
									document.location.href = '?auth_key=' + authKey;
								}
							});
						</script>
						@endpush
					<?php endif ?>
				</li>
			</ul>
		</div>
	</nav>
</div>