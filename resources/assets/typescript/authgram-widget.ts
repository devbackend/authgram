/**
 * Виджет авторизации через telegram бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
const BASE_URL      = 'API_URL';
const AUTH_BASE_URL = BASE_URL + '/auth/';

const DEFAULT_SELECTOR = '[data-role="authgram-bot"]';

const AUTHGRAM_BUTTON_TEXT = 'Войти через Telegram';

const DEFAULT_CLASS_AUTHGRAM_BUTTON = 'authgram-button';
const DEFAULT_CLASS_CODE_CONTAINER  = 'authgram-command-container';

const CHANNEL_AUTH_COMMAND_STATUS   = 'auth-command-status';
const EVENTS_USER_JOIN_SUCCESS      = 'UserJoinSuccessEvent';
const EVENTS_USER_JOIN_FAIL         = 'UserJoinFailEvent';

class AuthGramWidget {
	public uuid:        string;
	public selector:    string  = DEFAULT_SELECTOR;

	protected channelName;
	protected expireTimer;
	protected reloadTimer;

	public onAuthSuccess = (authKey: string) => {
		document.location.href = '?auth_key=' + authKey;
	};

	public onAuthFail = (reason) => {
		let errorMessage = document.createElement('p');
		errorMessage.classList.add('authgram-bot-widget-container');
		errorMessage.innerHTML = '<p class="command-error">' + reason + '. Попробуйте снова.</p>';

		this.drawAuthoriseButton(errorMessage.outerHTML);
	};

	protected htmlContainer: Element;

	/**
	 * @param {string}  uuid    Идентификатор приложения
	 * @param {Object}  config  Параметры виджета
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	constructor(uuid: string, config?) {
		this.uuid = uuid;

		Object.keys(config).forEach((key) => {
			this[key] = config[key];
		});

		//-- Устанавливаем селектор
		this.htmlContainer = document.querySelector(this.selector);
		if (null === this.htmlContainer) {
			throw new Error('Элемент "' + config.selector + '" не найден');
		}
		//-- -- -- --

		//-- Добавляем дополнительный класс для стилизации
		this.htmlContainer.classList.add('authgram-bot-widget-container');
		//-- -- -- --

		//-- Подключаем стили
		let widgetStyles = document.createElement('link');
		widgetStyles.setAttribute('rel', 'stylesheet');
		widgetStyles.setAttribute('href', BASE_URL + '/css/authgram-widget.css');
		//-- -- -- --

		//-- Подключаем скрипты
		let listenerScript = document.createElement('script');
		listenerScript.setAttribute('type', 'application/javascript');
		listenerScript.setAttribute('src', BASE_URL + '/js/authgram-listener.js');
		//-- -- -- --

		document.querySelector('head').appendChild(listenerScript);
		document.querySelector('head').appendChild(widgetStyles);

		this.drawAuthoriseButton();
	}

	/**
	 * Отрисовка кнопки авторизации.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawAuthoriseButton = (containerHtml = '') => {
		let button = document.createElement('button');
		button.className = DEFAULT_CLASS_AUTHGRAM_BUTTON;
		button.innerHTML = AUTHGRAM_BUTTON_TEXT;
		button.addEventListener('click', this.getCommand, false);

		this.htmlContainer.innerHTML = containerHtml;
		this.htmlContainer.appendChild(button);
	};

	/**
	 * Получение telegram-команды для авторизации на сайте.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected getCommand = () => {
		let callback = 'getCommand' + Math.floor(Math.random() * 1024) + 1;

		this.htmlContainer.innerHTML = '<p class="getting-command">Загрузка данных...</p>';
		this[callback] = (response) => {
			this.drawCommandContainer(response);

			delete this[callback];
		};
		(<any>window).AuthGramWidget = this;

		if (undefined !== this.channelName) {
			(<any>window).Echo.leave(this.channelName);
		}

		let elem = document.createElement("script");
		elem.src = AUTH_BASE_URL + this.uuid + '/' + 'window.AuthGramWidget.' + callback;
		document.head.appendChild(elem);
	};

	/**
	 * Отрисовка блока с командой
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawCommandContainer(response) {
		let commandContainer = document.createElement('div');
		commandContainer.className = DEFAULT_CLASS_CODE_CONTAINER;
		if (undefined !== response.error) {
			commandContainer.innerHTML = '<div class="command-error">' + response.error + '</div>';
		}
		else {
			commandContainer.innerHTML = '<div class="command">'
				+ '<span>Чтобы войти на сайт, отправьте боту следующую команду:</span> '
				+ '<a href="https://telegram.me/BOT_NAME" target="_blank" class="command">'
				+ '/' + response.command + ''
				+ '</a>'
				+ '</div>'
				+ '<div class="expired">'
				+ '<span>Истекает через 00:</span>'
				+ '<span data-role="expired-value">' + response.expired + '</span>'
				+ '</div>'
			;

			//-- Устанавливаем таймер
			this.expireTimer = (<any>window).setInterval(() => {
				let expiredElem  = this.htmlContainer.querySelector('[data-role="expired-value"]');
				let expiredValue = parseInt(expiredElem.textContent) - 1;

				expiredElem.textContent = (expiredValue < 10 ? '0' : '') + expiredValue;
			}, 1000);
			//-- -- -- --

			//-- Перезагружаем код через указанное время
			this.reloadTimer = (<any>window).setTimeout(() => {
				(<any>window).clearInterval(this.expireTimer);

				this.getCommand();
			}, response.expired * 1000);
			//-- -- -- --
		}

		this.htmlContainer.innerHTML = '';
		this.htmlContainer.appendChild(commandContainer);

		this.channelName = CHANNEL_AUTH_COMMAND_STATUS + '.' + response.command;

		//-- Начинаем слушать ответ от сервера
		(<any>window).Echo
			.channel(this.channelName)
			.listen(EVENTS_USER_JOIN_SUCCESS, (eventUserJoinSuccess) => {
				(<any>window).clearInterval(this.expireTimer);
				(<any>window).clearInterval(this.reloadTimer);
				(<any>window).Echo.leave(this.channelName);

				this.onAuthSuccess(eventUserJoinSuccess.authKey);
			})
			.listen(EVENTS_USER_JOIN_FAIL, (eventUserJoinFail) => {
				(<any>window).clearInterval(this.expireTimer);
				(<any>window).clearInterval(this.reloadTimer);
				(<any>window).Echo.leave(this.channelName);

				this.onAuthFail(eventUserJoinFail.reason);
			})
		;
		//-- -- -- --
	}
}