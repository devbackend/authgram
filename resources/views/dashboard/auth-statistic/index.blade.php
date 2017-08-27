<?php

use App\Entities\LogAuthAttempt;

/**
 * Шаблон для страницы попыток авторизации
 *
 * @var LogAuthAttempt[] $attempts Логи попыток авторизации
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$attemptClasses = [
	LogAuthAttempt::STEP_GET_CODE       => 'light-blue accent-1',
	LogAuthAttempt::STEP_GET_COMMAND    => 'yellow accent-1',
	LogAuthAttempt::STEP_AUTH_FAIL      => 'red accent-1',
	LogAuthAttempt::STEP_AUTH_SUCCESS   => 'green accent-1',
];

?>

@extends('layouts.frontend')

@section('content')
	<h1>Логи попыток авторизации</h1>

	<table>
		<thead>
		<tr>
			<th>#</th>
			<th>Шаг/статус</th>
			<th>Приложение</th>
			<th>Пользователь</th>
			<th>Команда</th>
			<th>Время</th>
		</tr>
		</thead>

		<tbody>
		<?php  foreach ($attempts as $attempt): ?>
			<tr class="<?= $attemptClasses[$attempt->step] ?>">
				<td><?= $attempt->id ?></td>
				<td>
					<p><?= $attempt->getStepTitle() ?></p>
					<p><?= $attempt->getStepInfo() ?></p>
				</td>
				<td><?= (null !== $attempt->application ? $attempt->application->title  : 'Неизвестно') ?></td>
				<td><?= (null !== $attempt->user        ? $attempt->user->getName()     : 'Неизвестно') ?></td>
				<td><?= $attempt->command ?></td>
				<td><?= $attempt->insert_stamp ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<?= $attempts->links() ?>
@endsection