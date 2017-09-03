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
			<td><?= $log->insert_stamp->format('d.m.Y H:i:s') ?></td>
			<td class="level"><?= $log->getLevelTitle() ?></td>
			<td class="category"><?= basename($log->category) ?></td>
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

	<?= $logs->links() ?>

@endsection

@push('styles')
	<style>
		.logs-table th {
			padding: 15px;
			text-align: center;
		}

		.logs-table th + th {
			margin-left: 20px;
		}

		.logs-table td.message {
			width: 650px;
		}

		.logs-table th:nth-child(1) {
			width: 135px;
		}

		.logs-table .level,
		.logs-table .category {
			text-align: center;
		}
	</style>
@endpush