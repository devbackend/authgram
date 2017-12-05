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
	<div class="col s6">
		<h2>Инфо</h2>

		<p><b>Идентификатор telegram:</b>   &mdash; <?= $user->telegram_id ?></p>

		<p><b>Username:</b>                 &mdash; <?= ('' !== $user->username     ? $user->username   : '<i>пусто</i>') ?></p>
		<p><b>Имя:</b>                      &mdash; <?= ('' !== $user->first_name   ? $user->first_name : '<i>пусто</i>') ?></p>
		<p><b>Фамилия:</b>                  &mdash; <?= ('' !== $user->last_name    ? $user->last_name  : '<i>пусто</i>') ?></p>

		<p><b>Дата создания:</b>            &mdash; <?= $user->created_at ?></p>
		<p><b>Дата обновления:</b>          &mdash; <?= $user->updated_at ?></p>
	</div>
	<div class="col s6">
		<h2>Приложения</h2>
		<?php if (0 === count($user->applications)): ?>
			<p><b>Приложений нет</b></p>
		<?php else: ?>
			<?php foreach ($user->applications as $application): ?>
				<p>
					<a href="<?= action(ApplicationController::class . '@show', ['uuid' => $application->uuid]) ?>" target="_blank">
						<?= $application->title ?>
					</a>
					&nbsp;
					<a href="<?= $application->website ?>" target="_blank">
						<i class="material-icons">launch</i>
					</a>
				</p>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>