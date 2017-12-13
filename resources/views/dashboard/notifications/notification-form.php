<?php

/**
 * Шаблон формы рассылки.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Http\Controllers\Dashboard\Notifications\NotificationRealSendController;
use App\Http\Controllers\Dashboard\Notifications\NotificationTestSendController;

?>

<h1>Отправка уведомлений</h1>

<div>
	<label for="notification_text">Текст уведомления</label>
	<textarea class="resizable_textarea form-control" placeholder="" name="notification_text" id="notification_text"></textarea>
</div>

<hr>

<div class="text-center">
	<button class="btn btn-primary" data-role="text-send" data-url="<?= action(NotificationTestSendController::class) ?>">
		Протестировать
	</button>

	<button class="btn btn-success" data-role="real-send" data-url="<?= action(NotificationRealSendController::class) ?>" disabled>
		Отправить всем
	</button>
</div>