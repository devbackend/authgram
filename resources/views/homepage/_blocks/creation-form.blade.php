<?php
/**
 * Шаблон главной страницы приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Application;
?>

<h3>Добавить приложение</h3>

<div class="row" id="creation-form">
	<div class="col s12 errors">
		<ul></ul>
	</div>

	<form class="col s12" action="<?= action('ApplicationController@createAction') ?>" method="post" data-role="create-application-form">
		{{ csrf_field() }}
		<div class="row">
			<div class="input-field col s6">
				<input type="text" name="<?= Application::TITLE ?>" class="validate" required placeholder="Например: Авторизатор" value="<?= old(Application::TITLE) ?>" id="field-<?= Application::TITLE ?>">
				<label for="field-<?= Application::TITLE ?>">Название приложения или сайта</label>
			</div>
			<div class="input-field col s6">
				<input type="text" name="<?= Application::WEBSITE ?>" placeholder="Например: http://example.com" class="validate" data-inputmask-url required value="<?= old(Application::WEBSITE) ?>" id="field-<?= Application::WEBSITE ?>">
				<label for="field-<?= Application::WEBSITE ?>">Адрес сайта</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input type="text" name="<?= Application::REDIRECT_URL ?>" class="validate" data-inputmask-url required placeholder="Например: http://example.com/profile" value="<?= old(Application::REDIRECT_URL) ?>" id="field-<?= Application::REDIRECT_URL ?>">
				<label for="field-<?= Application::REDIRECT_URL ?>">URL-адрес, на который перенаправить пользователя после авторизации</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input type="text" name="<?= Application::AUTH_REQUEST_URL ?>" class="validate" data-inputmask-url required placeholder="Например: http://example.com/secret-auth-path" value="<?= old(Application::AUTH_REQUEST_URL) ?>" id="field-<?= Application::AUTH_REQUEST_URL ?>">
				<label for="field-<?= Application::AUTH_REQUEST_URL ?>">URL-адрес, на который будут отправлять авторизационные данные пользователя</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12 center-align" data-role="submit-container">
				<button class="btn waves-effect waves-light" type="submit" name="action">Submit
					<i class="material-icons right">send</i>
				</button>

				<div class="progress hide">
					<div class="indeterminate"></div>
				</div>
			</div>
		</div>
	</form>
</div>