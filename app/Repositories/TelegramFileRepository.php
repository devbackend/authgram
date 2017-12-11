<?php

namespace App\Repositories;

use Illuminate\Filesystem\Filesystem;
use Telegram\Bot\Api;

/**
 * Репозиторий для работы с файлами Telegram.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class TelegramFileRepository {
	/** @var Api */
	private $telegram;

	public function __construct() {
		$this->telegram = app(Api::class);
	}

	/**
	 * Загрузка файла.
	 *
	 * @param string $fileId Идентификатор файла
	 *
	 * @return string
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function downloadFile(string $fileId): string {
		$filePath = $this->telegram->getFile(['file_id' => $fileId]);
		$fileUrl  = 'https://api.telegram.org/file/bot' . $this->telegram->getAccessToken() . '/' . $filePath->getFilePath();

		$tmpPath = public_path('files/' . microtime(true));

		copy($fileUrl, $tmpPath);

		$type = app(Filesystem::class)->mimeType($tmpPath);
		$type = explode('/', $type);
		$type = end($type);

		$filename = sha1_file($tmpPath) . '.' . $type;
		$localPath = implode(DIRECTORY_SEPARATOR, [
			'files',
			substr($filename, 0, 2),
			substr($filename, 2, 2)
		]);

		if (false === file_exists(public_path($localPath))) {
			mkdir(public_path($localPath), 0755, true);
		}

		$localPath .= DIRECTORY_SEPARATOR . $filename;

		app(Filesystem::class)->move($tmpPath, public_path($localPath));

		return str_replace(DIRECTORY_SEPARATOR, '/', $localPath);
	}
}