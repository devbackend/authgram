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

	/** @var string URL-адрес для перенаправления пользователя */
	public $redirectUrl = '';

	/**
	 * @param bool   $status        Статус проверки кода
	 * @param string $redirectUrl   URL-адрес для перенаправления пользователя
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(bool $status, string $redirectUrl) {
		$this->status       = $status;
		$this->redirectUrl  = $redirectUrl;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function broadcastOn() {
		return new Channel('check-code-status');
	}
}