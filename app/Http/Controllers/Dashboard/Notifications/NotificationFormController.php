<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\BackOfficeController;
use Illuminate\View\View;

/**
 * Форма редактирования рассылки.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class NotificationFormController extends BackOfficeController {
	/**
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke() {
		return $this->render('index');
	}
}