<?php

use App\Entities\User;

/**
 * Шаблон для страницы сообщений
 *
 * @var User[] $users Сообщения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<h1>Пользователи</h1>

	<table>
		<thead>
		<tr>
			<th>Имя</th>
			<th>Количество приложений</th>
			<th>Дата добавления</th>
			<th></th>
		</tr>
		</thead>

		<tbody>
		<?php  foreach ($users as $user): ?>
		<tr>
			<td>
				<a href="<?= action('Dashboard\UserController@showAction', ['uuid' => $user->uuid]) ?>" target="_blank">
					<?= $user->getName() ?>
				</a>
			</td>
			<td>
				<?= $user->applications()->count() ?>
			</td>
			<td>
				<?= $user->getCreationTime() ?>
			</td>
			<td></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<?= $users->links() ?>
@endsection