<ul class="collapsible" data-collapsible="accordion" data-role="developers-faq">
	<li>
		<div class="collapsible-header"><i class="material-icons">info_outline</i>Что такое <?= env('BOT_NAME') ?>?</div>
		<div class="collapsible-body">
			<p>
				<?= env('BOT_NAME') ?> - сервис авторизации пользователей при помощи Telegram. Весь процесс, со стороны пользователя, сводится к тому, чтобы получить код
				идентификации и отправить его боту, который передаст данные из профиля Telegram на тот сайт, где совершается вход. Со стороны сайта
				необходимо принять авторизационные данные пользователя и идентифицировать его.
			</p>
			<p>
				Весь процесс авторизации поэтапно можно представить следующим образом:
			</p>
			<ol>
				<li>
					Пользователь, при помощи виджета, отправляет запрос на авторизацию и получает авторизационный код.
				</li>
				<li>
					При помощи мессенджера Telegram пользователь отправляет данный код боту
					<a href="https://telegram.me/authgrambot" target="_blank">@<?= env('BOT_NAME') ?>Bot</a>
				</li>
				<li>
					Бот подтверждает авторизацию и отправляет данные о пользователе на ваш сайт при помощи POST запроса на URL-адрес,
					который вы указали при регистрации.
				</li>
				<li>
					Помимо данных пользователя и секретного токена вашего приложения, таке будет отправлен авторизационный ключ.
					В случае успешного получения ответа от сайта, такой же ключ будет отправлен в виджет авторизации
					для дальнейшего связывания клиентской и серверной стороны авторизации.
				</li>
			</ol>
		</div>
	</li>
	<li>
		<div class="collapsible-header"><i class="material-icons">vpn_key</i>Подключение javascript-виджета на сайте</div>
		<div class="collapsible-body">
			<p>Для того, чтобы использовать виджет <?= env('BOT_NAME') ?>, разместите следующий код на своём сайте:</p>
			<blockquote>
				<pre><!--
	                -->&lt;div data-role=&quot;authgram-bot&quot; class=&quot;authgram-widget&quot;&gt;&lt;/div&gt;
<!--                -->&lt;script type=&quot;text/javascript&quot; src=&quot;https://cdn.authgram.ru/js/authgram-widget.js&quot;&gt;&lt;/script&gt;
<!--                -->&lt;script type=&quot;text/javascript&quot;&gt;
<!--                -->    var AuthGramWidget = new AuthGramWidget('[UUID ВАШЕГО ПРИЛОЖЕНИЯ]', [НАСТРОЙКИ]);
<!--                -->&lt;/script&gt;<!--
				--></pre>
			</blockquote>
			<p>
				Конструктор виджета принимает на вход два параметра - uuid вашего приложения и объект с настройками.
				Настройки являются необязательным параметром, но они позволяют более гибко настроить взаимодействие пользователя с виджетом авторизации.
			</p>

			<h3>Доступные настройки</h3>
			<ul>
				<li>
					<b>selector</b> &mdash; селектор, который является контейнером виджета. По умолчанию - <i>data-role="authgram-bot"</i>
				</li>
				<li>
					<b>onAuthSuccess(authKey)</b> &mdash; метод, который выполняется при успешной авторизации.
					На вход подаётся ключ авторизации, который отправлен на серверную часть вашего сайта.
					По умолчанию происходит редирект на ту же страницу. Но вы можете определить здесь свою собственную логику
					для работы с авторизацией пользователя.
				</li>
				<li>
					<b>onAuthFail()</b> &mdash; метод, который выполняется при ошибке авторизации.
					По умолчанию пользователю отображается ошибка и заново отрисовывается кнопка для получения кода.
				</li>
			</ul>

			<h3>Методы для работы с виджетом</h3>
			<ul>
				<li>
					<b>drawAuthoriseButton(message)</b> &mdash; отрисовка кнопки получения кода.
					В качестве параметра вы можете передать html-контент, который небходимо отобразить перед кнопкой.
				</li>
			</ul>
		</div>
	</li>
	<li>
		<div class="collapsible-header"><i class="material-icons">code</i>Получение авторизационных данных пользователя</div>
		<div class="collapsible-body">
			<p>
				После того, как пользователь отправит код потверждения боту, инициируется отправка данных на сайт, где выполняется вход.
				Будет отправлен POST запрос, в теле которого находится json следующего вида:
			</p>
			<pre>
{
	"token":    "[ТОКЕН ВАШЕГО ПРИЛОЖЕНИЯ]",
	"authKey":  "[КЛЮЧ АВТОРИЗАЦИИ ПОЛЬЗОВАТЕЛЯ]",
	"user": {
		"uuid":         "[ИДЕНТИФИКАТОР ПОЛЬЗОВАТЕЛЯ В UUID ФОРМАТЕ]",
		"username":     "[НИКНЕЙМ ПОЛЬЗОВАТЕЛЯ]",
		"firstName":    "[ИМЯ ПОЛЬЗОВАТЕЛЯ]",
		"lastName":     "[ФАМИЛИЯ ПОЛЬЗОВАТЕЛЯ]"
	}
}
			</pre>
			<p>
				<i class="material-icons">info</i>
				<b>Важно:</b> при отправке POST запроса, бот ожидает ответ 200 от сервера. В случае, если этот ответ не будет получен,
				авторизация будет считаться проваленной.
			</p>
		</div>
	</li>
	<li>
		<div class="collapsible-header"><i class="material-icons">settings_input_hdmi</i>Готовые решения</div>
		<div class="collapsible-body">
			<p>
				<a href="https://github.com/devbackend/authgram-request-handler" target="_blank"><b>AuthGram Request Handler</b></a>
				&mdash;
				библиотека для обработки входящих запросов на авторизацию. Превращает тело POST запроса с данными в PHP объект, готовый к использованию
				в ваших приложениях
			</p>

			<hr>

			<p>
				Данный раздел находится в стадии наполнения. Если у вас есть готовое решение для обработки авторизации и вы хотите им поделиться,
				сообщите об этом нам - <a href="mailto:code@authgram.ru">code@authgram.ru</a> - и мы добавим ваш плагин в этот список.
			</p>
		</div>
	</li>
</ul>