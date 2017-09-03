<?php

use Illuminate\Http\Request;

?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">

	<title><?= env('BOT_NAME') ?> - сервис авторизации пользователей при помощи Telegram</title>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="/css/app.css">
	<link rel="shortcut icon" href="/favicon.png">

	{{-- Meta теги для импорта в соц.сети --}}
	<meta name="theme-color" content="#006064" />
	<meta property="og:site_name" content="AuthGram" />
	<meta property="og:title" content="Сервис авторизации при помощи Telegram" />

	<meta name="keywords" content="авторизация, telegram, telegram бот, аутентификация, личный кабинет">
	<meta name="description" property="og:description" content="Сервис авторизации при помощи Telegram. Весь процесс, со стороны пользователя, сводится к тому, чтобы получить команду авторизации и отправить её боту, который передаст данные из профиля Telegram на тот сайт, где совершается вход.">

	<meta name="image" property="og:image" content="https://authgram.ru/images/logo.png" />

	<meta property="og:image:width" content="640" data-ajax-meta-tag="true" />
	<meta property="og:image:height" content="640" data-ajax-meta-tag="true" />
	{{-- Meta теги для импорта в соц.сети --}}

	@stack('styles')
</head>
<body>
@include('layouts._blocks.nav')

<main>
	<div class="container">
		<?php if (session('request-success-message')): ?>
			<div class="card-panel green lighten-4 green-text text-darken-4">
				<?= session('request-success-message') ?>
			</div>
		<?php endif ?>

		<?php if (session('request-error-message')): ?>
			<div class="card-panel red lighten-4 red-text text-darken-4">
				<?= session('request-error-message') ?>
			</div>
		<?php endif ?>

		@yield('content')
	</div>
</main>

@include('layouts._blocks.footer')

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/materialize.min.js"></script>
<script type="text/javascript" src="/js/all.js"></script>
@stack('scripts')

<?php if (false === app()->isLocal() && false === strpos(app()->make(Request::class)->path(), 'dashboard')): ?>
	@include('layouts._blocks.counters')
<?php endif ?>

</body>
</html>