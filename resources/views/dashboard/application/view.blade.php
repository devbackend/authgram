<?php

use App\Entities\Application;use Illuminate\Support\ViewErrorBag;

/**
 * Шаблон страницы приложения.
 *
 * @var Application  $application Приложение
 * @var ViewErrorBag $errors      Ошибки при сохранении формы
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<h1>Приложение "<?= $application->title ?>"</h1>

	<div class="row">
		<?php if (0 !== $errors->count()): ?>
			<div class="card-panel red lighten-4 red-text text-darken-4">
				<?php foreach ($errors->all() as $error): ?>
						<?= $error ?>
					<?php endforeach ?>
			</div>
		<?php endif ?>

		<form action="<?= action('Dashboard\ApplicationController@update', ['uuid' => $application->uuid]) ?>" method="post" class="col s12">
			<?= csrf_field() ?>
			<?= method_field('PUT') ?>

			<div class="row">
				<div class="input-field col s6">
					<input id="title" name="title" class="validate" type="text" value="<?= $application->title ?>" required>
					<label for="title">Название</label>
				</div>

				<div class="input-field col s6">
					<input id="website" name="website" class="validate" type="text" value="<?= $application->website ?>" required>
					<label for="website">Сайт</label>
				</div>

				<div class="input-field col s12">
					<input id="auth_request_url" name="auth_request_url" class="validate" type="text" value="<?= $application->auth_request_url ?>" required>
					<label for="auth_request_url">URL-адрес, на который будут отправляться авторизационные данные пользователя</label>
				</div>

				<div class="input-field col s12">
					<textarea name="success_auth_message" id="success_auth_message"
					          class="materialize-textarea"><?= $application->success_auth_message ?></textarea>
					<label for="success_auth_message">Сообщение, которое будет отпправлено пользователю при успешной авторизации</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12 center-align">
					<button class="btn waves-effect waves-light">Сохранить
						<i class="material-icons right">send</i>
					</button>
				</div>
			</div>
		</form>
	</div>
@endsection