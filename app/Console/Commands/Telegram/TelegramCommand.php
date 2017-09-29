<?php

namespace App\Console\Commands\Telegram;

use App\Repositories\UserRepository;
use App\Wrappers\TelegramMessage;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Logging\Log;
use Telegram\Bot\Commands\Command;

/**
 * Базовый класс команд Telegram бота.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class TelegramCommand extends Command {
	/** @var Repository Кэширование */
	protected $cache;

	/** @var Log Логгер */
	protected $logger;

	/** @var UserRepository Репозиторий пользователей */
	protected $users;

	public function __construct() {
		$this->cache  = resolve(Repository::class);
		$this->logger = resolve(Log::class);
		$this->users  = resolve(UserRepository::class);
	}

	/**
	 * Инициализация сообщения
	 *
	 * @return TelegramMessage
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function initiateMessage() {
		return new TelegramMessage;
	}
}