<?php

namespace App\Events;

use App\Entities\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Событие авторизации пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserJoined implements ShouldBroadcast {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/** @var User $user Инстанс авторизованного пользователя. */
	public $user;

	/**
	 * @param User $user Инстанс авторизованного пользователя
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function broadcastOn() {
		return new Channel('application-auth');
	}
}
