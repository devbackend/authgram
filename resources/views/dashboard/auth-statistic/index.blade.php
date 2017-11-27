<?php

use App\Entities\LogAuthStep;use Illuminate\Pagination\LengthAwarePaginator;use Ramsey\Uuid\Uuid;

/**
 * Шаблон для страницы попыток авторизации
 *
 * @var LogAuthStep[]|LengthAwarePaginator  $attempts   Идентификаторы попыток авторизации
 * @var LogAuthStep[][]                     $authSteps  Логи шагов авторизации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$stepTitles  = LogAuthStep::getStepTitles();
$stepNumbers = array_keys($stepTitles);

?>

@extends('layouts.frontend')

@section('content')
	<h1>Логи попыток авторизации</h1>

	<table class="bordered">
		<thead>
		<tr>
			<th>Команда</th>
			<th>Приложение</th>
			<th>Пользователь</th>
			<th>Запрос кода</th>
			<th>Отправка команды</th>
			<th>Результат</th>
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

				$classList = ['text-accent-4'];
				if (true === $isSuccess) {
					$classList[] = 'teal accent-1 teal-text';
				}
				elseif (true === $isFail) {
					$classList[] = 'red lighten-3 red-text';
				}
			?>
			<tr id="attempt-<?= $attempt->attempt_guid ?>" class="<?= implode(' ', $classList) ?>">
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
						<p><b>Успех</b></p>

						<p><?= $steps[LogAuthStep::STEP_AUTH_SUCCESS]->message ?></p>
					<?php elseif (true === $isFail): ?>
						<p><b>Неудача</b></p>

						<p><?= $steps[LogAuthStep::STEP_AUTH_FAIL]->message ?></p>
					<?php else :?>
						<p><b>Неизвестен</b></p>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<?= $attempts->links() ?>
@endsection

@push('styles')
<style>

</style>
@endpush