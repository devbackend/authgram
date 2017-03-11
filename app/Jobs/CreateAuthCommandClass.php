<?php

namespace App\Jobs;

use App\Console\Commands\Telegram\AuthoriseCommand;
use App\Entities\AuthCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Создание класса авторизации для нового приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class CreateAuthCommandClass implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var AuthCommand Инстанс команды авторизации */
	protected $authCommand;

	/**
	 * @param AuthCommand $authCommand Инстанс команды авторизации
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __construct(AuthCommand $authCommand) {
		$this->authCommand = $authCommand;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		$commandsDir = base_path('app/Console/Commands/Telegram/AuthoriseCommands/');
		$namespace   = 'App\Console\Commands\Telegram\AuthoriseCommands';

		//-- Создаём класс для команды
		$className = ucfirst($this->authCommand->command) . 'Command';
		$commandCode = implode(PHP_EOL, [
			'<?php',
			'namespace ' . $namespace . ';',
			'use ' . AuthoriseCommand::class . ';',
			'class ' . $className . ' extends ' . class_basename(AuthoriseCommand::class) . ' {protected $name = \'' . $this->authCommand->command . '\';}',
		]);
		file_put_contents(
			$commandsDir . $className . '.php',
			$commandCode
		);
		//-- -- -- --

		//-- Обновляем файл кэша
		$cached = [];
		foreach(scandir($commandsDir) as $file) {
			if (in_array($file, ['.', '..', '.gitignore', 'cached.php'])) {
				continue;
			}

			$class = explode('.', $file);
			$class = reset($class);

			$cached[] = "\t" . $namespace . '\\' . $class . '::class,';
		}

		file_put_contents($commandsDir . 'cached.php', implode(PHP_EOL, [
			'<?php',
			'return [',
			implode(PHP_EOL, $cached),
			'];',
		]));
		//-- -- -- --
	}
}
