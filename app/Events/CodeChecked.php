<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Событие проверки кода.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CodeChecked implements ShouldBroadcast {
	/** @var bool Статус проверки кода */
	public $status = false;

	/** @var string Код авторизации пользователя */
	public $authKey = '';

	/** @var int Авторизационный код */
	protected $authCode;

	/**
	 * @param int    $authCode  Авторизационный код
	 * @param bool   $status    Статус проверки кода
	 * @param string $authKey   Ключ авторизации
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(int $authCode, bool $status, string $authKey) {
		$this->authCode = $authCode;
		$this->status   = $status;
		$this->authKey  = $authKey;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function broadcastOn() {
		return new Channel('check-code-status.' . $this->authCode);
	}
}