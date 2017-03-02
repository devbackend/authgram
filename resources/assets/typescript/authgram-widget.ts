/**
 * Виджет авторизации через telegram бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
const BASE_URL      = 'https://authgram.ru';
const AUTH_BASE_URL = BASE_URL + '/auth/';

const DEFAULT_SELECTOR = '[data-role="authgram-bot"]';

const AUTHGRAM_BUTTON_TEXT = 'Войти через Telegram';

const DEFAULT_CLASS_AUTHGRAM_BUTTON = 'authgram-button';
const DEFAULT_CLASS_CODE_CONTAINER  = 'authgram-code-container';

const CHANNEL_CHECK_CODE_STATUS = 'check-code-status';
const COMMAND_CODE_CHECKED      = 'CodeChecked';

class AuthGramWidget {
	public uuid:        string;
	public selector:    string  = DEFAULT_SELECTOR;

	public onAuthSuccess = (authKey: string) => {
		document.location.href = '?auth_key=' + authKey;
	};

	public onAuthFail = () => {
		let errorMessage = document.createElement('p');
		errorMessage.classList.add('authgram-bot-widget-container');
		errorMessage.innerText = 'При авторизации произошла ошибка. Попробуйте снова.';

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

		Object.keys(config).forEach((key) => { this[key] = config[key];});

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
		button.addEventListener('click', this.getCode, false);

		this.htmlContainer.innerHTML = containerHtml;
		this.htmlContainer.appendChild(button);
	};

	/**
	 * Получение кода авторизации
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected getCode = () => {
		let callback = 'getCode' + Math.floor(Math.random() * 1024) + 1;

		this.htmlContainer.innerHTML = '<p class="getting-code">Получение кода...</p>';
		this[callback] = (responseCode) => {
			this.drawCodeContainer(responseCode);

			delete this[callback];
		};
		(<any>window).AuthGramWidget = this;

		let elem = document.createElement("script");
		elem.src = AUTH_BASE_URL + this.uuid + '/' + 'window.AuthGramWidget.' + callback;
		document.head.appendChild(elem);
	};

	/**
	 * Отрисовка блока с кодом
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawCodeContainer(response) {
		let codeContainer = document.createElement('div');
		codeContainer.className = DEFAULT_CLASS_CODE_CONTAINER;
		codeContainer.innerHTML = '<div class="code">'
			+ '<span>Ваш код авторизации:</span> '
			+ '<span class="code">' + response.code + '</span>'
			+ '</div>'
			+ '<div class="expired">'
			+ '<span>Истекает через 00:</span>'
			+ '<span data-role="expired-value">' + response.expired + '</span>'
			+ '</div>'
		;

		this.htmlContainer.innerHTML = '';
		this.htmlContainer.appendChild(codeContainer);

		//-- Устанавливаем таймер
		let expireTimer = (<any>window).setInterval(() => {
			let expiredElem  = this.htmlContainer.querySelector('[data-role="expired-value"]');
			let expiredValue = parseInt(expiredElem.textContent) - 1;

			expiredElem.textContent = (expiredValue < 10 ? '0' : '') + expiredValue;
		}, 1000);
		//-- -- -- --

		//-- Перезагружаем код через указанное время
		(<any>window).setTimeout(() => {
			(<any>window).clearInterval(expireTimer);

			this.getCode();
		}, response.expired * 1000);
		//-- -- -- --

		//-- Начинаем слушать ответ от сервера
		(<any>window).Echo
			.channel(CHANNEL_CHECK_CODE_STATUS + '.' + response.code)
			.listen(COMMAND_CODE_CHECKED, (e) => {
				//-- Если произошла ошибка, сообщаем пользователю и рисуем кнопку заново
				if (false === e.status) {
					this.onAuthFail();

					return;
				}
				//-- -- -- --

				this.onAuthSuccess(e.authKey);
			})
		;
		//-- -- -- --
	}
}