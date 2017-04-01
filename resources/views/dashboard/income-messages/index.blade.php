<?php

use App\Entities\LogIncomeMessage;

/**
 * Шаблон для страницы сообщений
 *
 * @var LogIncomeMessage[] $messages Сообщения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<h1>Лог входящих сообщений</h1>

	<table>
		<thead>
		<tr>
			<th>#</th>
			<th>Пользователь</th>
			<th>Текст сообщения</th>
			<th>Время создания</th>
			<th></th>
		</tr>
		</thead>

		<tbody>
			<?php  foreach ($messages as $message): ?>
				<tr>
					<td>
						<?= $message->id ?>
					</td>
					<td>
						<a href="<?= action('Dashboard\UserController@showAction', ['uuid' => $message->user->uuid]) ?>" target="_blank">
							<?= $message->user->getName() ?>
						</a>
					</td>
					<td>
						<?= $message->getContent() ?>
					</td>
					<td>
						<?= $message->getCreationTime() ?>
					</td>
					<td></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<?= $messages->links() ?>
@endsection