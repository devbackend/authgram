<?php

use App\Entities\Application;

/**
 * Шаблон для страницы приложений
 *
 * @var Application[] $applications Приложения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
?>

@extends('layouts.frontend')

@section('content')
	<table>
		<thead>
			<tr>
				<th>Название</th>
				<th>Адрес</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($applications as $application): ?>
				<tr>
					<td>
						<b><?= $application->title ?></b>
					</td>
					<td>
						<a href="<?= $application->website ?>" target="_blank"><?= $application->website ?></a>
					</td>
					<td>
						<a href="<?= action('Dashboard\ApplicationController@show', ['uuid' => $application->uuid]) ?>">Редактировать</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
@endsection