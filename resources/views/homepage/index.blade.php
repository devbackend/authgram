<?php
/**
 * Шаблон главной страницы приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Page;use App\Http\Controllers\PagesController;

?>

@extends('layouts.frontend')

@section('content')
	<div class="page-block">
		<h1>
			Сервис авторизации пользователей при помощи Telegram.
		</h1>

		<p>
			<?= env('BOT_NAME') ?> &mdash; посредник между telegram-аккаунтом пользователя и ресурсом, на котором совершается вход.
			Его задача &mdash; получение запроса на авторизацию и передачу всех необходимых данных сайту, на котором происходит авторизация.
		</p>

		<div class="about-col">
			<h3>Пользователям сайтов</h3>

			<p>
				При помощи <?= env('BOT_NAME') ?>Bot вы сможете забыть о том, чтобы вводить на каждом сайте свой логин и пароль.
				Всё что вам необходимо для доступа - это приложение Telegram и добавить бота в свой контакт лист.
				После этого, вы сможете авторизовываться на сайтах, которые поддерживают вход через бота <?= env('BOT_NAME') ?>.
			</p>

			<p class="center">
				<a href="https://telegram.me/<?= env('BOT_NAME') ?>bot" class="waves-effect waves-light btn-large" target="_blank">Начать использовать <?= env('BOT_NAME') ?></a>
			</p>
		</div>
		<div class="about-col">
			<h3>Владельцам сайтов</h3>
			<p>
				<?= env('BOT_NAME') ?> - это javascript-виджет, который позводит пользователям вашего сайта выполнять вход при помощи одного из самых популярных мессенджеров - Telegram.
				После авторизации пользователя, вам будут отправлены данные, которые доступны из его профиля в Telegram и вы сможете идентифицировать его на своё сайте.
			</p>

			<p>
				<?= env('BOT_NAME') ?> имеет простой javascript-API - вы можете разместить сгенерированный код на сайте, без каких-либо изменений,
				и это позволит пользователям совершать вход через <?= env('BOT_NAME') ?>.
			</p>

			<p class="center">
				<a href="<?= action(PagesController::class . '@showAction', [Page::SLUG => 'add']) ?>" class="waves-effect waves-light btn-large" data-scroll-nav="1">Добавить виджет на свой сайт</a>
			</p>
		</div>
	</div>
@endsection