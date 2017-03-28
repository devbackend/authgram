<?php

namespace App\Entities;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

/**
 * Модель владельца приложения.
 *
 * @property int    $id             Идентификатор записи
 * @property string $user_uuid      Идентификатор пользователя
 * @property string $password       Хэш-сумма пароля
 * @property string $remember_token Токен для запоминания авторизации пользователя
 * @property string $created_at     Дата создания записи
 * @property string $updated_at     Дата обновления записи
 *
 * @property-read \App\Entities\User $user
 *
 * @method static Eloquent where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Owner create($attributes = [])
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class Owner extends User {
	use Notifiable;

	const ID                = 'id';
	const USER_UUID         = 'user_uuid';
	const PASSWORD          = 'password';
	const REMEMBER_TOKEN    = 'remember_token';

	/** @var string[] Поля, доступные для массового заполнения */
	protected $fillable = [self::USER_UUID];

	/** @var string[] Поля, недоступные для выборки в массивах */
	protected $hidden = [self::PASSWORD, self::REMEMBER_TOKEN];

	/**
	 * Связь с пользователем.
	 *
	 * @return HasOne
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function user() {
		return $this->hasOne(\App\Entities\User::class, \App\Entities\User::UUID, static::USER_UUID);
	}
	const RELATED_USER = 'user';
}
