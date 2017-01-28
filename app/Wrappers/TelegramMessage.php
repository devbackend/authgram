<?php
namespace App\Wrappers;

/**
 * Вспомогательный класс для генерации сообщения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class TelegramMessage {
	/** @var int|string Идентификатор чата */
	protected $chatId;

	/** @var string Текст сообщения */
	protected $text;

	/** @var string Режим пасринга */
	protected $parseMode;

	/** @var bool Отключить предпросмотр ссылок */
	protected $disableWebPagePreview;

	/** @var int Идентификатор сообщения, на которое производится ответ */
	protected $replyToMessageId;

	/** @var string Метка об ответе */
	protected $replyMarkup;

	/**
	 * Установка идентификатора чата
	 *
	 * @param int|string $chatId
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setChatId($chatId) {
		$this->chatId = $chatId;

		return $this;
	}

	/**
	 * Установка текста сообщения
	 *
	 * @param string $text
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setText(string $text) {
		$this->text = $text;

		return $this;
	}

	/**
	 * Установка режима парсинга
	 *
	 * @param string $parseMode
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setParseMode(string $parseMode) {
		$this->parseMode = $parseMode;

		return $this;
	}

	/**
	 * Установка предпросмотра ссылок
	 *
	 * @param bool $disableWebPagePreview
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setDisableWebPagePreview(bool $disableWebPagePreview) {
		$this->disableWebPagePreview = $disableWebPagePreview;

		return $this;
	}

	/**
	 * Установка идентификатора собщения, на которое производится ответ
	 *
	 * @param int $replyToMessageId
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setReplyToMessageId(int $replyToMessageId) {
		$this->replyToMessageId = $replyToMessageId;

		return $this;
	}

	/**
	 * Установка метки ответа
	 *
	 * @param string $replyMarkup
	 *
	 * @return static
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function setReplyMarkup(string $replyMarkup) {
		$this->replyMarkup = $replyMarkup;

		return $this;
	}

	/**
	 * Получение массива сообщения для передачи в методы.
	 *
	 * @return array
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function get() {
		$result = [];

		if (null !== $this->chatId) {
			$result['chat_id'] = $this->chatId;
		}

		if (null !== $this->text) {
			$result['text'] = $this->text;
		}

		if (null !== $this->parseMode) {
			$result['pare_mode'] = $this->parseMode;
		}


		if (null !== $this->disableWebPagePreview) {
			$result['disable_web_page_preview'] = $this->disableWebPagePreview;
		}

		if (null !== $this->replyToMessageId) {
			$result['reply_to_message_id'] = $this->replyToMessageId;
		}

		if (null !== $this->replyMarkup) {
			$result['reply_markup'] = $this->replyMarkup;
		}

		return $result;
	}
}