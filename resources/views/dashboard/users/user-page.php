<?php

use App\Entities\User;
use App\Http\Controllers\ApplicationController;

/**
 * Шаблон страницы пользователя
 *
 * @var User $user Инстанс пользователя
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

<h1>Пользователь <?= $user->getName() ?></h1>

<div class="row">
	<div class="col-md-offset-3 col-md-6">
		<table class="table">
			<?php if (null !== $user->profile_photo): ?>
				<tr>
					<td colspan="2" class="text-center">
						<img src="<?= url($user->profile_photo) ?>" alt="<?= $user->getName() ?>">
					</td>
				</tr>
			<?php endif ?>
			<tr>
				<td>Идентификатор telegram</td>
				<td><?= $user->telegram_id ?></td>
			</tr>
			<tr>
				<td>Username</td>
				<td><?= ('' !== $user->username ? $user->username : '<i>пусто</i>') ?></td>
			</tr>
			<tr>
				<td>Имя</td>
				<td><?= ('' !== $user->first_name ? $user->first_name : '<i>пусто</i>') ?></td>
			</tr>
			<tr>
				<td>Фамилия</td>
				<td><?= ('' !== $user->last_name ? $user->last_name : '<i>пусто</i>') ?></td>
			</tr>
			<tr>
				<td>Дата первого собщения</td>
				<td><?= $user->created_at ?></td>
			</tr>
			<tr>
				<td>Дата последнего собщения</td>
				<td><?= $user->updated_at ?></td>
			</tr>

			<?php if (0 !== count($user->applications)): ?>
				<tr>
					<td>Подписан на рассылку</td>
					<td><?= ($user->notification_enabled ? 'Да' : 'Нет') ?></td>
				</tr>

				<tr>
					<td colspan="2">
						<h2>Приложения</h2>

						<table class="table">
							<tr>
								<th>Название</th>
								<th>Сайт</th>
							</tr>

							<?php foreach ($user->applications as $application): ?>
								<tr>
									<td>
										<a href="<?= action(ApplicationController::class . '@show', ['uuid' => $application->uuid]) ?>" target="_blank">
											<?= $application->title ?>
										</a>
									</td>
									<td>
										<a href="<?= $application->website ?>" target="_blank">
											<?= $application->website ?>
										</a>
									</td>
								</tr>
							<?php endforeach ?>
						</table>
					</td>
				</tr>
			<?php endif ?>
		</table>
	</div>
</div>