<?php

namespace App\Console\Commands;

use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\TelegramResponse;

/**
 * Команда для включения/отключения webhook'ов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class WebhookSwitchCommand extends Command {
	const ARGUMENT_STATE = 'state';

	/** @var string Сигнатура команды */
	protected $signature = 'webhook {' . self::ARGUMENT_STATE . '}';

	/** @var string Описание команды*/
	protected $description = 'Переключение бота в DEV-режиме (использовать webhook\'и или нет)';

	/**
	 * Выполнение команды
	 *
	 * @throws Exception
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle() {
		$mode = $this->argument(static::ARGUMENT_STATE);

		$method = 'switch' . ucfirst($mode);
		if (false === method_exists($this, $method)) {
			throw new Exception('Неизвестный режим: ' . $mode);
		}

		return $this->$method();
	}

	/**
	 * Включение webhook'а.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function switchOn() {
		$webhookUrl = route(RouteServiceProvider::ROUTE_NAME_WEBHOOK, ['token' => env('TELEGRAM_BOT_TOKEN')]);

		/** @var TelegramResponse $response */
		$response = Telegram::setWebhook(['url' => $webhookUrl]);
		if (200 !== $response) {
			$this->error(
				$response->getDecodedBody()
			);

			return;
		}

		$this->info('Webhook успешно установлен: ' . $webhookUrl);
	}

	/**
	 * Удаление webhook'а.
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	protected function switchOff() {
		/** @var TelegramResponse $removeResponse */
		$removeResponse = Telegram::removeWebhook();

		if (200 !== $removeResponse->getHttpStatusCode()) {
			$this->error(
				$removeResponse->getDecodedBody()
			);

			return;
		}

		$this->info('Webhook успешно удалён');
	}
}
