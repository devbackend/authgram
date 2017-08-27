<?php

/**
 * Шаблон для главной страницы панели управления.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="col s12">
			<p>
				<a href="<?= action('Dashboard\UserController@indexAction') ?>" target="_blank">Пользователи</a>
			</p>

			<p>
				<a href="<?= action('Dashboard\ApplicationController@index') ?>" target="_blank">Приложения</a>
			</p>

			<p>
				<a href="<?= action('Dashboard\IncomeMessagesController@indexAction') ?>" target="_blank">Сообщения</a>
			</p>

			<p>
				<a href="<?= action('Dashboard\AuthStatistic@indexAction') ?>" target="_blank">Статистика авторизаций</a>
			</p>

			<p>
				<a href="<?= action('Dashboard\NotificationController@indexAction') ?>" target="_blank">Рассылка</a>
			</p>
		</div>
	</div>
@endsection