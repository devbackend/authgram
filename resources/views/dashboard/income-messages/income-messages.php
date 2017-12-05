<?php

use App\Entities\LogIncomeMessage;
use App\Http\Controllers\Dashboard\Users\UserPageController;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Шаблон для страницы сообщений
 *
 * @var LogIncomeMessage[]|LengthAwarePaginator $messages Сообщения
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

<h1>Лог входящих сообщений</h1>

<table class="table">
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
				<a href="<?= action(UserPageController::class, ['uuid' => $message->user->uuid]) ?>" target="_blank">
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

<div class="text-center">
	<?= $messages->links() ?>
</div>