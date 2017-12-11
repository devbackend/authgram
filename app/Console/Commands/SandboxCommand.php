<?php

namespace App\Console\Commands;

use App\Entities\User;
use App\Jobs\UserProfilePhotoDownload;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Throwable;


/**
 * Команда-песочница.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class SandboxCommand extends Command {
	protected $signature = 'sandbox';

	/**
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle() {
		$users = (new User())->newQuery()
			->select(User::UUID)
			->where(User::PROFILE_PHOTO, null)
			->orderByDesc(User::CREATED_AT)
			->limit(250)
			->get()
			->toArray()
		;

		foreach ($users as $user) {
			try {
				$this->info('Обработка пользователя ' . $user['uuid']);

				app(Dispatcher::class)->dispatch(
					new UserProfilePhotoDownload($user['uuid'])
				);
			}
			catch (Throwable $e) {
				$this->error($e->getMessage());
			}
		}
	}
}