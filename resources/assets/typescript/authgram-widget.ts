/**
 * Виджет авторизации через telegram бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
const BASE_URL      = 'https://authbot.devbackend.com/';
const AUTH_BASE_URL = BASE_URL + '/auth/';

const DEFAULT_SELECTOR = '[data-role="authorise-bot"]';

const AUTHORISE_BUTTON_TEXT = 'Войти через Telegram';

const DEFAULT_CLASS_AUTHORISE_BUTTON = 'authorise-button';
const DEFAULT_CLASS_CODE_CONTAINER   = 'authorise-code-container';

const CHANNEL_CHECK_CODE_STATUS = 'check-code-status';
const COMMAND_CODE_CHECKED      = 'CodeChecked';

class AuthoriseWidget {
	public uuid:        string;
	public selector:    string  = DEFAULT_SELECTOR;

	public onAuthSuccess    = function (authKey: string) {console.warn('Переопределите метод onAuthSuccess')};
	public onAuthFail       = function () {console.warn('Переопределите метод onAuthFail')};

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
		this.htmlContainer.classList.add('authorise-bot-widget-container');
		//-- -- -- --

		//-- Подключаем стили
		let widgetStyles = document.createElement('link');
		widgetStyles.setAttribute('rel', 'stylesheet');
		widgetStyles.setAttribute('href', BASE_URL + '/css/authorise-widget.css');
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
	 * Отображение кода пользователю.
	 *
	 * @param responseCode
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public showCode(responseCode) {
		this.drawCodeContainer(responseCode.code);
	}

	/**
	 * Отрисовка кнопки авторизации.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawAuthoriseButton = () => {
		let button = document.createElement('button');
		button.className = DEFAULT_CLASS_AUTHORISE_BUTTON;
		button.innerHTML = AUTHORISE_BUTTON_TEXT;
		button.addEventListener('click', this.getCode, false);

		this.htmlContainer.innerHTML = '';
		this.htmlContainer.appendChild(button);
	};

	/**
	 * Получение кода авторизации
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected getCode = () => {
		this.htmlContainer.innerHTML = 'Получение кода...';

		(<any>window).AuthoriseWidget = this;

		let elem = document.createElement("script");
		elem.src = AUTH_BASE_URL + this.uuid;
		document.head.appendChild(elem);
	};

	/**
	 * Отрисовка блока с кодом
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected drawCodeContainer(code: number) {
		let codeContainer = document.createElement('div');
		codeContainer.className = DEFAULT_CLASS_CODE_CONTAINER;
		codeContainer.innerHTML = '<span>Ваш код авторизации:</span> <span>' + code + '</span>';

		this.htmlContainer.innerHTML = '';
		this.htmlContainer.appendChild(codeContainer);

		//-- Начинаем слушать ответ от сервера
		(<any>window).Echo
			.channel(CHANNEL_CHECK_CODE_STATUS)
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