<?php

namespace App\Repositories;

use App\Entities\User;
use App\Exceptions\Handler;
use App\Jobs\UserProfilePhotoDownload;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Collection;
use Telegram\Bot\Objects\User as TelegramUser;
use Throwable;

/**
 * Репозиторий пользователей.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserRepository extends Repository {

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function get($id) {
		return $this->entity->where(User::UUID, $id)->first();
	}

	/**
	 * Получение идентификаторов пользователей, которые подписаны на рассылку бота.
	 *
	 * @return Collection|string[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getActiveOwnerIds(): Collection {
		$ownerIds = app(ApplicationRepository::class)->getApplicationOwnerIds();

		$ownerIds = $this->entity->newQuery()
			->whereIn(User::UUID, $ownerIds)
			->where(User::NOTIFICATION_ENABLED, true)
			->pluck(User::TELEGRAM_ID)
		;

		return $ownerIds;
	}

	/**
	 * Загрузка пользователя на основе данных телеграмма
	 *
	 * @param TelegramUser $telegramUser
	 *
	 * @return User
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function loadByTelegramProfile(TelegramUser $telegramUser) {
		$telegramId = $telegramUser->getId();

		$cacheKey   = $this->getCacheKey(__METHOD__, [$telegramId]);
		$user       = $this->cache->get($cacheKey);
		if (null === $user) {
			/** @var User $user */
			$user = $this->entity->firstOrNew([User::TELEGRAM_ID => $telegramId]);

			$user->username     = $telegramUser->getUsername()  ?? '';
			$user->first_name   = $telegramUser->getFirstName() ?? '';
			$user->last_name    = $telegramUser->getLastName()  ?? '';

			$user->save();

			$this->cache->put($cacheKey, $user, 24 * 60);

			if (null === $user->profile_photo) {
				try {
					app(Dispatcher::class)->dispatch(
						new UserProfilePhotoDownload($user->uuid)
					);
				}
				catch (Throwable $e) {
					app(Handler::class)->report($e);
				}
			}
		}

		return $user;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initEntity() {
		$this->entity = new User();
	}
}