<?php

namespace App\Console\Commands;

use App\Entities\User;
use Illuminate\Console\Command;

/**
 *
 *
 * @author Ivan Krivonos <devbackend@yandex.ru>
 */
class LastMessageSend extends Command {
	protected $signature = 'lastMessage';

	public function handle() {
		$users = (new User())->newQuery()
			->select(User::UUID)
			->where(User::LAST_MESSAGE_STATUS, null)
			->orderByDesc(User::CREATED_AT)
			->limit(10)
			->get()
		;

		dd($users);
	}
}
