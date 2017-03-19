<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserJoinSuccessEvent implements ShouldBroadcast {
	/** @var string Код авторизации пользователя */
	public $authKey = '';

	/** @var string Название команды */
	protected $commandName;

	/**
	 * @param string $commandName   Название команды
	 * @param string $authKey       Ключ авторизации пользователя
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(string $commandName, string $authKey) {
		$this->commandName  = $commandName;
		$this->authKey      = $authKey;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function broadcastOn() {
		return new Channel('auth-command-status.' . $this->commandName);
	}
}
