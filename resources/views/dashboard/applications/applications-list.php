<?php

use App\Entities\Application;
use App\Http\Controllers\Dashboard\Users\UserPageController;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Шаблон списка подключенных приложений.
 * 
 * @var LengthAwarePaginator|Application[] $applications
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

<h1>Приложения</h1>

<table class="table">
	<thead>
	<tr>
		<th>Название</th>
		<th>Адрес</th>
		<th>Адрес авторизации</th>
		<th>Владелец</th>
		<th>Дата добавления</th>
	</tr>
	</thead>

	<tbody>
		<?php foreach ($applications as $application): ?>
			<tr>
				<td><?= $application->title ?></td>
				<td>
					<a href="<?= $application->website ?>" target="_blank"><?= $application->website ?></a>
				</td>
				<td>
					<?= $application->auth_request_url ?>
				</td>
				<td>
					<a href="<?= action(UserPageController::class, ['uuid' => $application->owner_uuid]) ?>" target="_blank"><?= $application->owner->getName() ?></a>
				</td>
				<td>
					<?= $application->getCreationTime() ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
