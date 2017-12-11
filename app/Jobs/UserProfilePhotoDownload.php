<?php

namespace App\Jobs;

use App\Entities\User;
use App\Exceptions\Handler;
use App\Repositories\TelegramFileRepository;
use App\Repositories\UserRepository;
use Exception;
use Monolog\Logger;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\PhotoSize;

/**
 * Класс задачи: получение аватара пользователя.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class UserProfilePhotoDownload extends AbstractQueueJob {
	/** @var string */
	private $userId;

	/**
	 * @param string    $userId
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(string $userId) {
		$this->userId = $userId;
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle() {
		$telegram = app(Api::class);
		$user     = app(UserRepository::class)->get($this->userId);/** @var User $user */
		if (null === $user) {
			app(Logger::class)->error('Невозможно получить фото профиля: пользователь ' . $this->userId . ' не найден');

			return;
		}

		try {
			$response = $telegram->getUserProfilePhotos(['user_id' => $user->telegram_id]);
		}
		catch (Exception $e) {
			app(Handler::class)->report($e);

			return;
		}

		/** @var PhotoSize $photos */
		$photos = $response->getPhotos();

		if (true === $photos->isEmpty()) {
			return;
		}

		$photo = $photos->first();
		$photo = end($photo);

		$user->profile_photo = app(TelegramFileRepository::class)->downloadFile($photo['file_id']);
		$user->save();
	}
}
