<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\HasOne;

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
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getMessageDataAttribute($value) {
		return json_decode($value);
	}

	/**
	 * Получение текста собщения
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getContent() {
		return (property_exists($this->message_data->message, 'text')
			? $this->message_data->message->text
			: 'Не текстовое сообщение'
		);
	}

	/**
	 * Пользователь, оставивший сообщение
	 *
	 * @return HasOne
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function user() {
		return $this->hasOne(User::class, User::UUID, static::USER_UUID);
	}
}