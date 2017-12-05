<?php

use App\Entities\User;
use App\Http\Controllers\Dashboard\Users\UserPageController;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Шаблон для страницы сообщений
 *
 * @var LengthAwarePaginator|User[] $users Сообщения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

<h1>Пользователи</h1>

<table class="table">
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
				<a href="<?= action(UserPageController::class, ['uuid' => $user->uuid]) ?>" target="_blank">
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


<div class="text-center">
	<?= $users->links() ?>
</div>