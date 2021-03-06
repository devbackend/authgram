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
		<th></th>
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
				<?php if (null !== $user->profile_photo): ?>
					<img src="<?= url($user->profile_photo) ?>" alt="<?= $user->getName() ?>" width="50">
				<?php endif ?>
			</td>
			<td>
				<a href="<?= action(UserPageController::class, ['uuid' => $user->uuid]) ?>">
					<?= $user->getName() ?>
				</a>
			</td>
			<td>
				<?= count($user->applications) ?>
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