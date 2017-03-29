<?php
/**
 * Шаблон главной страницы приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Application;
?>

<h1>
	Добавить виджет на сайт
</h1>

<?php if (false === Auth::check()): ?>
	<p>Для того, чтобы добавить виджет на свой сайт, вам необходимо авторизоваться.</p>
	<p>Для авторизации совершите следующие шаги:</p>
	<ol>
		<li>Нажмите на сайте кнопку "Войти через Telegram"</li>
		<li>Дождитесь команду для авторизации</li>
		<li>Отправьте эту команду боту <a href="https://telegram.me/<?= env('BOT_NAME') ?>bot" target="_blank"><?= env('BOT_NAME') ?>Bot</a></li>
	</ol>
	<p>После этого</p>
	<ul>
		<li>&mdash; в случае успеха: авторизация на сайте должна произойти автоматически, от вас не требуется больше никаких действий</li>
		<li>
			&mdash; в случае ошибки: вы будете уведомлены о причинах и будет снова предложено войти при помощи бота
			<a href="https://telegram.me/<?= env('BOT_NAME') ?>bot" target="_blank"><?= env('BOT_NAME') ?>Bot</a>
		</li>
	</ul>

	<button data-role="authgram-sign-button" class="authgram-sign-button"><span>Войти через Telegram</span></button>
<?php else: ?>
	<div class="row" id="creation-form">
		<p>Для того чтобы начать использовать возможности <?= env('BOT_NAME') ?>, необходимо добавить свой сайт при помощи формы ниже, указав все необходимые данные.</p>
		<p>После этого вы получите идентификатор вашего приложения, токен доступа и код виджета для вставки его на своём сайте.</p>
		<p>Вам останется настроить скрипт по указанному адресу на принятие данных пользователя и его идентификацию.</p>

		<div class="col s12 errors">
			<ul></ul>
		</div>

		<form class="col s12" action="<?= action('ApplicationController@createAction') ?>" method="post" data-role="create-application-form">
			{{ csrf_field() }}
			<input type="hidden" name="<?= Application::OWNER_UUID ?>" value="<?= Auth::user()->user_uuid ?>">
			<div class="row">
				<div class="input-field col s12 m6 l6">
					<input type="text" name="<?= Application::TITLE ?>" class="validate" required placeholder="Например: Авторизатор" value="<?= old(Application::TITLE) ?>" id="field-<?= Application::TITLE ?>">
					<label for="field-<?= Application::TITLE ?>">Название приложения или сайта</label>
				</div>
				<div class="input-field col s12 m6 l6">
					<input type="url" name="<?= Application::WEBSITE ?>" placeholder="Например: http://example.com" class="validate" data-inputmask-url required value="<?= old(Application::WEBSITE) ?>" id="field-<?= Application::WEBSITE ?>">
					<label for="field-<?= Application::WEBSITE ?>">Адрес сайта</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<input type="url" name="<?= Application::AUTH_REQUEST_URL ?>" class="validate" data-inputmask-url required placeholder="Например: http://example.com/secret-auth-path" value="<?= old(Application::AUTH_REQUEST_URL) ?>" id="field-<?= Application::AUTH_REQUEST_URL ?>">
					<label for="field-<?= Application::AUTH_REQUEST_URL ?>">URL-адрес, на который будут отправляться авторизационные данные пользователя</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12 center-align" data-role="submit-container">
					<button class="btn waves-effect waves-light" type="submit" name="action">Добавить
						<i class="material-icons right">send</i>
					</button>

					<div class="progress hide">
						<div class="indeterminate"></div>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php endif ?>