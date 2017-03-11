<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Создание команды для Telegram
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateTelegramCommand extends Command {
	/** @inheritdoc */
	protected $signature = 'make:telegram-command {commandName}';

	/** @inheritdoc */
	protected $description = 'Создание класса для Telegram команды';

	/**
	 * Запуск команды
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function handle() {
		$commandName = $this->argument('commandName');

		$className = studly_case($commandName) . 'Command';

		$commandContent = '<?php' . "\n"
			. "\n"
			. 'namespace App\Console\Commands\Telegram;' . "\n"
			. "\n"
			. '/**' . "\n"
			. ' *' . "\n"
			. ' *' . "\n"
			. ' * @author Кривонос Иван <devbackend@yandex.ru>' . "\n"
			. ' */' . "\n"
			. 'class ' . $className . ' extends TelegramCommand {' . "\n"
			. "\t" . '/** @var string Название команды */' . "\n"
			. "\t" . 'protected $name = \'' . $commandName . '\';' . "\n"
			. "\n"
			. "\t" . '/** @var string Описание команды */' . "\n"
			. "\t" . 'protected $description = \'Описание для команды \\\'' . $commandName . '\\\'\';' . "\n"
			. "\n"
			. "\t" . '/**' . "\n"
			. "\t" . ' * @inheritdoc' . "\n"
			. "\t" . ' *' . "\n"
			. "\t" . ' * @author Кривонос Иван <devbackend@yandex.ru>' . "\n"
			. "\t" . ' */' . "\n"
			. "\t" . 'public function handle($arguments) {' . "\n"
			. "\t\t" . '// TODO: Implement handle() method.' . "\n"
			. "\t" . '}' . "\n"
			. '}' . "\n";

			file_put_contents(
				base_path('app/Console/Commands/Telegram/') . $className . '.php',
				$commandContent
			);
	}
}
