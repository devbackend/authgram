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
				'Для того чтобы отправить код используйте команду /i после которой укажите необходимый код.',
				'К примеру: если авторизационный код 1234, отправьте боту ',
				'/i 1234'
			]))
			->get()
		;

		$this->replyWithMessage($message);
	}
}