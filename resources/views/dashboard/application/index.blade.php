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
				<th>Токен</th>
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
						<?= $application->api_token ?>
					</td>
					<td class="app-controls">
						<?php if (false === $application->trashed()): ?>
							<a href="<?= action('Dashboard\ApplicationController@show', ['uuid' => $application->uuid]) ?>">Редактировать</a>

							<?php if (Auth::user()->user_uuid === $application->owner_uuid): ?>
							<a href="javascript:" onclick="document.getElementById('delete-app-<?= $application->uuid ?>').submit();" class="red-text">Удалить</a>

							<form
								id="delete-app-<?= $application->uuid ?>"
								action="<?= action('Dashboard\ApplicationController@delete', ['uuid' => $application->uuid]) ?>"
								method="post"
							>
								<?= csrf_field() ?>
								<?= method_field('DELETE') ?>
							</form>
							<?php endif ?>
						<?php else: ?>
							<b class="red-text">Удалено</b>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
@endsection

@push('styles')
	<style>
		.app-controls > a,
		.app-controls > b {
			margin-left: 10px;
		}
	</style>
@endpush