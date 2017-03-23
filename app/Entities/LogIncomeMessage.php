<?php
namespace App\Entities;

/**
 * Модель для хранения входящего собщения.
 *
 * @property int    $id
 * @property string $user_uuid
 * @property string $message_data
 * @property string $created_at
 * @property string $updated_at
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class LogIncomeMessage extends Entity {
	const ID            = 'id';
	const USER_UUID     = 'user_uuid';
	const MESSAGE_DATA  = 'message_data';

	protected $fillable = [self::USER_UUID, self::MESSAGE_DATA];
}