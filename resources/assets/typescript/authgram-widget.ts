/**
 * Виджет авторизации через telegram бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
//-- Настройки url-адресов
const API_URL      = '%API_URL%';
const AUTH_BASE_URL = API_URL + '/auth/';
//-- -- -- --

//-- Селекторы и классы виджета
const SELECTOR_SIGN_BUTTON      = '[data-role="authgram-sign-button"]';
const CLASS_NAME_MODAL          = 'authgram-modal';
const CLASS_NAME_MODAL_SHADOW   = 'authgram-modal-shadow';
const CLASS_NAME_HIDDEN_ELEMENT = 'authgram-hidden-element';
//-- -- -- --

//-- Канал и события
const CHANNEL_AUTH_COMMAND_STATUS   = 'auth-command-status';
const EVENTS_USER_JOIN_SUCCESS      = 'UserJoinSuccessEvent';
const EVENTS_USER_JOIN_FAIL         = 'UserJoinFailEvent';
//-- -- -- --

const CDN_VERSION = 20170827;

class AuthGramWidget {
	public uuid:            string;
	public messageClass:    string  = '';
	public selector:        string  = SELECTOR_SIGN_BUTTON;

	public onAuthSuccess = (authKey: string) => {
		document.location.href = '?auth_key=' + authKey;
	};

	public onAuthFail = (reason) => {
		let errorMessage = document.createElement('p');
		errorMessage.classList.add('authgram-bot-widget-container');
		errorMessage.innerHTML = '<p class="command-error">' + reason + '. Попробуйте снова.</p>';

		this.authGramModal.innerHTML = '';
		this.authGramModal.appendChild(errorMessage);
	};

	protected authgramSignButtons:  NodeListOf<Element>;
	protected authGramModal:        Element;
	protected authGramModalShadow:  Element;
	protected channelName;
	protected expireTimer;
	protected reloadTimer;

	/**
	 * @param {string}  uuid    Идентификатор приложения
	 * @param {Object}  config  Параметры виджета
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	constructor(uuid: string, config?) {
		this.uuid   = uuid;
		config      = config || {};

		Object.keys(config).forEach((key) => {
			this[key] = config[key];
		});

		//-- Устанавливаем селектор
		this.authgramSignButtons = document.querySelectorAll(this.selector);
		if (0 === this.authgramSignButtons.length) {
			return;
		}
		//-- -- -- --

		//-- Подключаем стили
		let widgetStyles = document.createElement('link');
		widgetStyles.setAttribute('rel', 'stylesheet');
		widgetStyles.setAttribute('href', API_URL + '/css/authgram-widget.css?v=' + CDN_VERSION);
		//-- -- -- --

		//-- Подключаем скрипты
		let listenerScript = document.createElement('script');
		listenerScript.setAttribute('type', 'application/javascript');
		listenerScript.setAttribute('src', API_URL + '/js/authgram-listener.js?v=' + CDN_VERSION);
		//-- -- -- --

		document.querySelector('head').appendChild(listenerScript);
		document.querySelector('head').appendChild(widgetStyles);

		for (let i in this.authgramSignButtons) {
			if (false === this.authgramSignButtons.hasOwnProperty(i)) {
				continue;
			}

			this.authgramSignButtons[i].addEventListener('click', this.getCommand, false);
		}

		this.drawModal();
	}

	/**
	 * Получение telegram-команды для авторизации на сайте.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected getCommand = () => {
		this.showModal();
		this.authGramModal.innerHTML = '<p class="getting-command">Получение кода...</p>';

		let callback = 'getCommand' + Math.floor(Math.random() * 1024) + 1;

		this[callback] = (response) => {
			this.drawCommandContainer(response);

			delete this[callback];
		};
		(<any>window).AuthGramWidget = this;

		if (undefined !== this.channelName) {
			(<any>window).AuthgramListener.getPusher().leave(this.channelName);
		}

		let elem = document.createElement('script');
		elem.src = AUTH_BASE_URL + this.uuid + '/' + 'window.AuthGramWidget.' + callback;
		document.head.appendChild(elem);
	};

	/**
	 * Отрисовка блока с командой
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawCommandContainer(response) {
		if (undefined !== response.error) {
			this.authGramModal.innerHTML = '<div class="command-error">' + response.error + '</div>';
		}
		else {
			this.authGramModal.innerHTML = '<div class="command ' + this.messageClass + '">'
				+ '<span class="click-head">Нажмите</span>'
				+ '<a href="https://telegram.me/%BOT_NAME%Bot/?start=' + response.command + '" target="_blank" class="sign-button">'
				+ 'Войти'
				+ '</a>'
				+ '<p class="start-rules">и в диалоге с ботом кликните по кнопке "START"</p>'
				+ '<span class="or-text">или</span>'
				+ 'Отправьте боту '
				+ '<a href="https://telegram.me/%BOT_NAME%Bot/" target="_blank" class="bot-link">@%BOT_NAME%Bot</a>'
				+ ' сообщение:'
				+ '<span class="command-name">/' + response.command + '</span>'
				+ '</div>'
				+ '<div class="expired">'
				+ '<span>Истекает через 00:</span>'
				+ '<span data-role="expired-value">' + response.expired + '</span>'
				+ '</div>'
				+ '<div class="powered">'
				+ 'powered by '
				+ '<a href="https://authgram.ru/?utm_source=' + (<any>window).location.hostname + '&utm_medium=powered_by" target="_blank">AuthGram.ru</a>'
				+ '</div>'
			;

			//-- Устанавливаем таймер
			this.expireTimer = (<any>window).setInterval(() => {
				let expiredElem  = this.authGramModal.querySelector('[data-role="expired-value"]');
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

		this.channelName = CHANNEL_AUTH_COMMAND_STATUS + '.' + response.command;

		//-- Начинаем слушать ответ от сервера
		(<any>window).AuthgramListener.getPusher()
			.channel(this.channelName)
			.listen(EVENTS_USER_JOIN_SUCCESS, (eventUserJoinSuccess) => {
				(<any>window).clearInterval(this.expireTimer);
				(<any>window).clearInterval(this.reloadTimer);
				(<any>window).AuthgramListener.getPusher().leave(this.channelName);

				this.onAuthSuccess(eventUserJoinSuccess.authKey);
			})
			.listen(EVENTS_USER_JOIN_FAIL, (eventUserJoinFail) => {
				(<any>window).clearInterval(this.expireTimer);
				(<any>window).clearInterval(this.reloadTimer);
				(<any>window).AuthgramListener.getPusher().leave(this.channelName);

				this.onAuthFail(eventUserJoinFail.reason);
			})
		;
		//-- -- -- --
	}

	/**
	 * Отрисовка модального окна для авторизации
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawModal = () => {
		this.authGramModalShadow = this.authGramModal = null;

		//-- Создание элемента для подложки виджета
		let closeHandler = () => {
			this.hideModal();
		};

		this.authGramModalShadow = document.createElement('div');
		this.authGramModalShadow.classList.add(CLASS_NAME_MODAL_SHADOW, CLASS_NAME_HIDDEN_ELEMENT);
		this.authGramModalShadow.addEventListener('click', closeHandler, false);
		document.body.appendChild(this.authGramModalShadow);
		//-- -- -- --

		//-- Создание элемента модального окна
		this.authGramModal = document.createElement('div');
		this.authGramModal.classList.add(CLASS_NAME_MODAL, CLASS_NAME_HIDDEN_ELEMENT);
		document.body.appendChild(this.authGramModal);
		//-- -- -- --
	};

	/**
	 * Отображение модального окна.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected showModal = () => {
		this.authGramModal.classList.remove(CLASS_NAME_HIDDEN_ELEMENT);
		this.authGramModalShadow.classList.remove(CLASS_NAME_HIDDEN_ELEMENT);
	};

	/**
	 * Удаление контейнера с кодом
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected hideModal = () => {
		(<any>window).clearInterval(this.expireTimer);
		(<any>window).clearInterval(this.reloadTimer);
		(<any>window).AuthgramListener.getPusher().leave(this.channelName);

		this.authGramModal.classList.add(CLASS_NAME_HIDDEN_ELEMENT);
		this.authGramModalShadow.classList.add(CLASS_NAME_HIDDEN_ELEMENT);
		this.authGramModal.innerHTML = '';
	};
}