<?php
namespace App\Entities;

use ErrorException;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Telegram\Bot\Objects\Update;

/**
 * Модель для хранения входящего собщения.
 *
 * @property int    $id             Идентификатор собщения
 * @property string $user_uuid      Идентификатор сообщения
 * @property string $message_data   Данные сообщения
 *
 * @property-read User $user Пользователь, оставивший сообщение
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogIncomeMessage extends Entity {
	const ID            = 'id';
	const USER_UUID     = 'user_uuid';
	const MESSAGE_DATA  = 'message_data';

	protected $fillable = [self::USER_UUID, self::MESSAGE_DATA];

	/**
	 * Преобразование сообщения в объект
	 *
	 * @param string $value
	 *
	 * @return Update
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getMessageDataAttribute($value) {
		$message = $value;

		try {
			$message = stripslashes($message);
			$message = unserialize($message);
		} catch (ErrorException $e) {
			// -- Пытаемся разобрать собщения, сохранённые старым способом
			$message = json_decode($value);
			if (null === $message) {
				$message = '[Не удалось разобрать собщение]';
			}
			else {
				$message = $message->message;

				if (false !== property_exists($message, 'text')) {
					$message = $message->text;
				}
				elseif (false !== property_exists($message, 'photo')) {
					$message = '[Прислано фото]';
				}
				elseif (false !== property_exists($message, 'contact')) {
					$message = '[Прислан контакт]';
				}
				elseif (false !== property_exists($message, 'document')) {
					$message = '[Прислан документ]';
				}
				elseif (false !== property_exists($message, 'sticker')) {
					$message = '[Стикер]';
				}
				elseif (false !== property_exists($message, 'left_chat_participant')
				        || false !== property_exists($message, 'new_chat_title')
				        || false !== property_exists($message, 'new_chat_participant')
				        || false !== property_exists($message, 'migrate_from_chat_id')
				        || false !== property_exists($message, 'migrate_to_chat_id')
				        || false !== property_exists($message, 'new_chat_photo')
				) {
					$message = '[Действие в чате, куда добавлен бот]';
				}
				else {
					dd($message);
				}
			}
			// -- -- -- --
		}

		return $message;
	}

	/**
	 * Получение текста собщения
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getContent() {
		/** @var Update $content */
		$content = $this->message_data;
		if (false === ($content instanceof Update)) {
			return $content;
		}

		$message = $content->getMessage();
		$text    = $message->getText();
		if (null === $text) {
			if (null !== $message->getAudio()) {
				$text = 'Аудиофайл';
			}
			elseif (null !== $message->getDocument()) {
				$text = 'Прислан документ';
			}
			elseif (null !== $message->getPhoto()) {
				$text = 'Прислано фото';
			}
			elseif (null !== $message->getSticker()) {
				$text = 'Стикер';
			}
			elseif (null !== $message->getVideo()) {
				$text = 'Видео файл';
			}
			elseif (null !== $message->getVoice()) {
				$text = 'Голосовое сообщение';
			}
			elseif (null !== $message->getContact()) {
				$text = 'Прислан контакт';
			}
			elseif (null !== $message->getLocation()) {
				$text = 'Прислано местоположение';
			}
			elseif (null !== $message->getNewChatParticipant()
				|| null !== $message->getLeftChatParticipant()
				|| null !== $message->getNewChatTitle()
				|| null !== $message->getMigrateFromChatId()
				|| null !== $message->getMigrateToChatId()
				|| null !== $message->getNewChatPhoto()
			) {
				$text = 'Действие в чате, куда добавлен бот';
			}
			else {
				$text = 'Неизвестный тип собщения';
			}

			$text = '[' . $text . ']';
		}

		return $text;
	}

	/**
	 * Пользователь, который оставил сообщение
	 *
	 * @return HasOne
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function user() {
		return $this->hasOne(User::class, User::UUID, static::USER_UUID);
	}
}