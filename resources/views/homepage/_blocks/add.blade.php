<?php
/**
 * Шаблон главной страницы приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Application;
?>

<?php if (false === Auth::check()): ?>
	<p>Для того, чтобы добавить виджет на свой сайт, вам необходимо авторизоваться.</p>
	<p>Сделать это вы можете, используя наш виджет.</p>
	<p>Нажмите кнопку "Войти через Telegram" для получения кода и отправьте этот код боту AuthGramBot при помощи команды /i &laquo;Полученный код&raquo;</p>
	<div id="telegram-auth-widget" class="telegram-auth-widget"></div>

	@push('scripts')
	<script type="text/javascript" src="/js/authgram-widget.js"></script>
	<script type="text/javascript">
		new AuthGramWidget('157bb070-eaee-11e6-84e2-0f2ab592a536', {
			selector: '#telegram-auth-widget',
			onAuthSuccess: function (authKey) {
				document.location.href = '?auth_key=' + authKey;
			}
		});
	</script>
	@endpush
<?php else: ?>
	<div class="row" id="creation-form">
		<p>Для того чтобы начать использовать возможности AuthGram, необходимо добавить свой сайт при помощи формы ниже, указав все необходимые данные.</p>
		<p>После этого вы получите идентификатор вашего приложения, токен доступа и код виджета для вставки его на своём сайте.</p>
		<p>Вам останется настроить скрипт по указанному адресу на принятие данных пользователя и его идентификацию.</p>

		<div class="col s12 errors">
			<ul></ul>
		</div>

		<form class="col s12" action="<?= action('ApplicationController@createAction') ?>" method="post" data-role="create-application-form">
			{{ csrf_field() }}
			<input type="hidden" name="<?= Application::OWNER_UUID ?>" value="<?= Auth::user()->user_uuid ?>">
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
					<input type="text" name="<?= Application::AUTH_REQUEST_URL ?>" class="validate" data-inputmask-url required placeholder="Например: http://example.com/secret-auth-path" value="<?= old(Application::AUTH_REQUEST_URL) ?>" id="field-<?= Application::AUTH_REQUEST_URL ?>">
					<label for="field-<?= Application::AUTH_REQUEST_URL ?>">URL-адрес, на который будут отправляться авторизационные данные пользователя</label>
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
<?php endif ?>