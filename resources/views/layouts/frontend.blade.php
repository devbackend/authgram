<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">

	<title>Авторизатор</title>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	@stack('styles')
</head>
<body>
@yield('content')

@stack('scripts')
</body>
</html>