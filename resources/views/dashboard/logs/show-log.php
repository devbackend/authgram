<?php

use App\Entities\Log;

/**
 * Шаблон страницы просмотра лога.
 *
 * @var Log $log
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
?>

<h1>Просмотр лога</h1>

<table class="table">
	<tr>
		<td>Сообщение:</td>
		<td><?= $log->message ?></td>
	</tr>
	<tr>
		<td>Тип:</td>
		<td><?= $log->getLevelTitle() ?></td>
	</tr>
	<tr>
		<td>Категория:</td>
		<td><?= $log->category ?></td>
	</tr>
	<tr>
		<td>Файл:</td>
		<td><?= $log->file ?></td>
	</tr>
	<tr>
		<td>Url:</td>
		<td><?= $log->method ?> <?= $log->url ?></td>
	</tr>
	<tr>
		<td>Параметры запроса:</td>
		<td><pre><?= print_r($log->params, true) ?></pre></td>
	</tr>
	<tr>
		<td>Дата:</td>
		<td><?= $log->insert_stamp->format('d.m.Y H:i:s') ?></td>
	</tr>
</table>

<h3>Стек вызова</h3>
<div class="stack">
	<?php foreach ($log->trace as $traceMessage): ?>
		<p>
			<?= $traceMessage ?>
		</p>
	<?php endforeach ?>
</div>