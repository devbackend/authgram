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

	@stack('styles')
</head>
<body>
@include('layouts._blocks.nav')

<main>
	<div class="container">
		@yield('content')
	</div>
</main>

@include('layouts._blocks.footer')

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/materialize.min.js"></script>
<script type="text/javascript" src="/js/all.js"></script>
@stack('scripts')
</body>
</html>