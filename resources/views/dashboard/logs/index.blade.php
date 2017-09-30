<?php

use App\Entities\Log;use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Шаблон страницы логов.
 *
 * @var LengthAwarePaginator $logs
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<h1>Логи</h1>

	<form action="<?= action('Dashboard\LogsController@deleteSelectedAction') ?>" method="post">
		<?= csrf_field() ?>
		<?= method_field('DELETE') ?>

		<table class="bordered logs-table">
			<tr>
				<th>Дата</th>
				<th>Уровень</th>
				<th>Категория</th>
				<th>Сообщение</th>
				<th></th>
			</tr>

			<?php foreach ($logs as $log): /** @var Log $log */ ?>
			<tr>
				<td class="date">
					<input type="checkbox" id="delete-<?= $log->guid ?>" name="guids[]" value="<?= $log->guid ?>"/>
					<label for="delete-<?= $log->guid ?>">
						<?= $log->insert_stamp->format('d.m.Y H:i:s') ?>
					</label>
				</td>
				<td class="level"><?= $log->getLevelTitle() ?></td>
				<td class="category"><?= class_basename($log->category) ?></td>
				<td class="message">
					<p>
						<b><?= $log->message ?></b>
					</p>
					<p>
						<small><?= $log->file ?></small>
					</p>
				</td>
				<td>
					<a href="<?= action('Dashboard\LogsController@showAction', ['guid' => $log->guid]) ?>">Перейти</a>
				</td>
			</tr>
			<?php endforeach ?>

		</table>

		<div class="controls">
			<button class="btn waves-effect waves-light" type="submit">
				Удалить выбранные
			</button>
		</div>
	</form>

	<div class="content-delete row">
		<form action="<?= action('Dashboard\LogsController@deleteContentAction') ?>" method="post">
			<?= csrf_field() ?>
			<?= method_field('DELETE') ?>

			<div class="col s6">
				<input placeholder="Лог" name="log" value="" id="delete-content" type="text"/>
			</div>
			<div class="col s6">
				<button class="btn waves-effect waves-light" type="submit">
					Удалить по содержимому
				</button>
			</div>
		</form>
	</div>

	<?= $logs->links() ?>

@endsection

@push('styles')
	<style>
		.logs-table th {
			padding:    15px;
			text-align: center;
		}

		.logs-table th + th {
			margin-left: 20px;
		}

		.logs-table td.date {
			width: 175px;
		}

		.logs-table td.message {
			max-width:     625px;
			word-wrap:     break-word;
			padding-right: 50px;
		}

		.logs-table th:nth-child(1) {
			width: 135px;
		}

		.logs-table .level,
		.logs-table .category {
			text-align: center;
		}

		.controls, .content-delete {
			margin-top: 25px;
		}

		.content-delete {
			border-top:  1px solid #d8d8d8;
			padding-top: 20px;
		}
	</style>
@endpush