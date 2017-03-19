<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserJoinFailEvent implements ShouldBroadcast {
	/** @var string Причина ошибки авторизации */
	public $reason = '';

	/** @var string Название команды */
	protected $commandName;

	/**
	 * @param string $commandName Название команды
	 * @param string $reason      Причина ошибки авторизации
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(string $commandName, string $reason) {
		$this->commandName  = $commandName;
		$this->reason       = $reason;
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