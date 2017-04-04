<?php

use App\Entities\Application;use App\Entities\LogIncomeMessage;use App\Entities\User;

/**
 * Шаблон для главной страницы ПУ
 *
 * @var User[]              $users          Срез последних добавившихся пользователей.
 * @var Application[]       $applications   Срез последних приложений
 * @var LogIncomeMessage[]  $incomeMessages Срез последних собщений
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<div class="row">
		<div class="col s6">
			<h2>Пользователи</h2>

			<?php foreach ($users as $user): ?>
				<p>
					<a href="<?= action('Dashboard\UserController@showAction', ['uuid' => $user->uuid]) ?>" target="_blank">
						<?= $user->getName() ?>
						&mdash;
						<?= $user->created_at ?>
					</a>
				</p>
			<?php endforeach ?>

			<a href="<?= action('Dashboard\UserController@indexAction') ?>">Смотреть всех</a>
		</div>

		<div class="col s6">
			<h2>Последние сообщения</h2>

			<?php foreach ($incomeMessages as $incomeMessage): ?>
				<p>
					<?= $incomeMessage->getContent() ?>
					&mdash;
					<?= $incomeMessage->getCreationTime() ?>
				</p>
			<?php endforeach ?>

			<a href="<?= action('Dashboard\IncomeMessagesController@indexAction') ?>">Смотреть все</a>
		</div>

		<div class="col s6">
			<h2>Последние приложения</h2>

			<?php foreach ($applications as $application): ?>
			<p>
				<a href="<?= action('Dashboard\ApplicationController@show', ['uuid' => $application->uuid]) ?>" target="_blank">
					<?= $application->title ?>
				</a>
				&mdash;
				<?= $application->getCreationTime() ?>
			</p>
			<?php endforeach ?>

			<a href="<?= action('Dashboard\ApplicationController@index') ?>">Смотреть все</a>
		</div>
	</div>
@endsection