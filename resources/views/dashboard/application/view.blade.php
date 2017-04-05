<?php

use App\Entities\Application;

/**
 * Шаблон страницы приложения.
 *
 * @var Application $application Приложение
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<h1>Приложение "<?= $application->title ?>"</h1>

	<p>
		Ссылка: <a href="<?= $application->website ?>" target="_blank"><?= $application->website ?></a>
	</p>
@endsection