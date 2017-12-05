<?php

use App\Entities\Log;
use App\Http\Controllers\Dashboard\Logs\DeleteByContentController;
use App\Http\Controllers\Dashboard\Logs\DeleteSelectedController;
use App\Http\Controllers\Dashboard\Logs\ShowLogController;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Шаблон страницы логов.
 *
 * @var LengthAwarePaginator $logs
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

<h1>Логи</h1>

<form action="<?= action(DeleteSelectedController::class) ?>" method="post">
	<?= csrf_field() ?>
	<?= method_field('DELETE') ?>

	<table class="table">
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
					<div class="checkbox">
						<label>
							<input type="checkbox" class="flat" id="delete-<?= $log->guid ?>" name="guids[]" value="<?= $log->guid ?>"/>
							<span>
								<?= $log->insert_stamp->format('d.m.Y H:i:s') ?>
							</span>
						</label>
					</div>
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
					<a href="<?= action(ShowLogController::class, ['guid' => $log->guid]) ?>">Перейти</a>
				</td>
			</tr>
		<?php endforeach ?>

	</table>

	<div class="text-center">
		<button class="btn btn-danger" type="submit">
			Удалить выбранные
		</button>
	</div>
</form>

<hr>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form action="<?= action(DeleteByContentController::class) ?>" method="post">
			<?= csrf_field() ?>
			<?= method_field('DELETE') ?>

			<div class="input-group">
				<input placeholder="Лог" class="form-control" name="log" value="" id="delete-content" type="text"/>
				<span class="input-group-btn">
				<button class="btn btn-danger" type="submit">Удалить по содержимому</button>
			</span>
			</div>
		</form>
	</div>
</div>

<div class="text-center">
	<?= $logs->links() ?>
</div>

<style>
	.date {
		width: 200px;
	}

	.date span {
		padding-left: 20px;
	}

	.level {
		width: 75px;
	}

	.checkbox label, .radio label {
		padding-left: 0;
	}
</style>