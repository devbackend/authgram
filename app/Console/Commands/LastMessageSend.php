<?php

namespace App\Console\Commands;

use App\Entities\User;
use App\Jobs\SendLastMessageTest3;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Throwable;

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
//			->where(User::LAST_MESSAGE_STATUS, null)
			->where(User::TELEGRAM_ID, 114307233)
			->orderBy(User::CREATED_AT)
			->limit(10)
			->get()
		;

		foreach ($users as $user) {
			try {
				$this->info('Обработка пользователя ' . $user['uuid']);

				app(Dispatcher::class)->dispatch(
					new SendLastMessageTest3($user['uuid'])
				);
			}
			catch (Throwable $e) {
				$this->error($e->getMessage());
			}
		}
	}
}
