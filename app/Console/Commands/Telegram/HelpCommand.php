<?php
namespace App\Console\Commands\Telegram;

/**
 *
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class HelpCommand extends TelegramCommand {
	/** @var string Название команды */
	protected $name = 'help';

	/** @var string Описание команды */
	protected $description = 'Помощь по работе с ботом';

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle($arguments) {
		$message = $this->initiateMessage()
			->setText(implode("\n\n", [
				'Для авторизации совершите следующие шаги:',
				'1. Намите на сайте кнопку "Войти через Telegram"',
				'2. Дождитесь команду для авторизации',
				'3. Отправьте эту команду мне',
				'После этого',
				'- в случае успеха: авторизация на сайте должна произойти автоматически, от вас не требуется больше никаких действий',
				'- в случае ошибки: вы будете уведомлены о причинах и будет снова предложено войти при помощи бота ' . env('BOT_NAME'),
			]))
			->get()
		;

		$this->replyWithMessage($message);
	}
}