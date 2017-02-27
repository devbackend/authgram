<p>
	<?= env('BOT_NAME') ?> - сервис авторизации пользователей при помощи Telegram. Весь процесс, со стороны пользователя, сводится к тому, чтобы получить код идентификации
	и отправить его боту, который передаст данные из профиля Telegram на тот сайт, где совершается вход. Со стороны сайта соответственно необходимо принять
	авторизационные данные пользователя и идентифицировать его.
</p>

<div class="about-col">
	<h3>Пользователям сайтов</h3>

	<p>
		При помощи <?= env('BOT_NAME') ?>Bot вы сможете забыть о том, чтобы вводить на каждом сайте свой логин и пароль.
		Всё что вам необходимо для доступа - это приложение Telegram и добавить бота в свой контакт лист.
		После этого вы сможете авторизовываться на сайтах, которые поддерживают вход через бота <?= env('BOT_NAME') ?>.
	</p>

	<p class="center">
		<a href="https://telegram.me/<?= env('BOT_NAME') ?>bot" class="waves-effect waves-light btn-large" target="_blank">Начать использовать <?= env('BOT_NAME') ?></a>
	</p>
</div>
<div class="about-col">
	<h3>Владельцам сайтов</h3>
	<p>
		<?= env('BOT_NAME') ?> - это javascript-виджет, который позводит пользователям вашего сайта выполнять вход при помощи одного из самых популярных мессенджеров - Telegram.
		После авторизации пользователя, вам будут отправлены данные, которые доступны из его профиля в Telegram,
		на основе которых вы сможете идентифицировать его на своё сайте.
	</p>

	<p>
		<?= env('BOT_NAME') ?> имеет простой javascript-API - вы можете разместить сгенерированный код, без каких-либо изменений, на сайте,
		и это позволит пользователям совершать вход через <?= env('BOT_NAME') ?>.
	</p>

	<p class="center">
		<a href="javascript:" class="waves-effect waves-light btn-large" data-scroll-nav="1">Добавить виджет на свой сайт</a>
	</p>
</div>