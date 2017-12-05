<?php

use App\Entities\LogAuthStep;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Uuid;

/**
 * Шаблон для страницы попыток авторизации
 *
 * @var LogAuthStep[]|LengthAwarePaginator  $attempts   Идентификаторы попыток авторизации
 * @var LogAuthStep[][]                     $authSteps  Логи шагов авторизации
 * @var int[]                               $checked    Выбранные шаги
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$stepTitles  = LogAuthStep::getStepTitles();
$stepNumbers = array_keys($stepTitles);

?>

<h1>Логи попыток авторизации</h1>

<form action="">
	<?php foreach ($stepTitles as $step => $title): ?>
		<div class="checkbox">
			<label>
				<input type="checkbox" class="flat" id="step<?= $step ?>" name="step[]" value="<?= $step ?>" <?= (true === in_array($step, $checked) ? 'checked' : '') ?> />
				<?= $title ?>
			</label>
		</div>
	<?php endforeach ?>

	<input type="submit" value="Показать" class="btn btn-primary">
</form>

<table class="table">
	<thead>
	<tr>
		<th>Команда</th>
		<th>Приложение</th>
		<th>Пользователь</th>
		<th>Запрос кода</th>
		<th>Отправка команды</th>
		<th>Результат</th>
		<th></th>
	</tr>
	</thead>

	<tbody>
	<?php  foreach ($attempts as $attempt): ?>
		<?php
		$steps = $authSteps[$attempt->attempt_guid];

		$application = null;
		$user        = null;
		$command     = null;

		if (true === array_key_exists(LogAuthStep::STEP_GET_CODE, $steps)) {
			$step = $steps[LogAuthStep::STEP_GET_CODE];

			$application = $step->application->title;
			$command     = $step->command;
		}

		if (true === array_key_exists(LogAuthStep::STEP_GET_COMMAND, $steps)) {
			$step = $steps[LogAuthStep::STEP_GET_COMMAND];

			$user        = $step->user->getName();

			if (null === $application && Uuid::NIL !== $step->application_uuid) {
				$application = $step->application->title;
			}

			if (null === $command) {
				$command = $step->command;
			}
		}

		$isSuccess  = array_key_exists(LogAuthStep::STEP_AUTH_SUCCESS,  $steps);
		$isFail     = array_key_exists(LogAuthStep::STEP_AUTH_FAIL,     $steps);
		?>
		<tr id="attempt-<?= $attempt->attempt_guid ?>">
			<td><?= $command ?></td>
			<td><?= $application ?? 'Неизвестно' ?></td>
			<td><?= $user ?? 'Неизвестен' ?></td>
			<td>
				<?= (array_key_exists(LogAuthStep::STEP_GET_CODE, $steps) ? '<b>' . $steps[LogAuthStep::STEP_GET_CODE]->insert_stamp . '</b>' : '<b>&mdash;</b>') ?>
			</td>
			<td>
				<?= (array_key_exists(LogAuthStep::STEP_GET_COMMAND, $steps) ? '<b>' . $steps[LogAuthStep::STEP_GET_COMMAND]->insert_stamp . '</b>' : '<b>&mdash;</b>') ?>
			</td>
			<td>
				<?php if (true === $isSuccess): ?>
					<span class="label label-success">Успех</span>
				<?php elseif (true === $isFail): ?>
					<span class="label label-danger">Неудача</span>
				<?php else :?>
					<span class="label label-default">Неизвестен</span>
				<?php endif ?>
			</td>
			<td>
				<?php if (true === $isSuccess): ?>
					<p><?= $steps[LogAuthStep::STEP_AUTH_SUCCESS]->message ?></p>
				<?php elseif (true === $isFail): ?>
					<p><?= $steps[LogAuthStep::STEP_AUTH_FAIL]->message ?></p>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>

<div class="text-center">
	<?= $attempts->links() ?>
</div>