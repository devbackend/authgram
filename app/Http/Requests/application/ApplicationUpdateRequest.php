<?php

namespace App\Http\Requests\application;

use App\Entities\Application;
use Illuminate\Validation\Rule;

/**
 * Запрос на обновление данных приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class ApplicationUpdateRequest extends ApplicationRequest {
	/** @var Application */
	protected $application;

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function authorize() {
		if (false === parent::authorize()) {
			return false;
		}

		return $this->getApplication()->isAvailableForCurrentUser();
	}


	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function rules() {
		return array_merge(
			parent::rules(),
			[
				Application::WEBSITE => [
					'required',
					'url',
					Rule::unique('applications')->ignore($this->getApplication()->uuid, Application::UUID)->whereNull(Application::DELETED_AT)
				],
			]
		);
	}

	/**
	 * Получение инстанса обновляемого приложения.
	 *
	 * @return Application
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function getApplication(): Application {
		if (null === $this->application) {
			$this->application = Application::find($this->route('uuid'));
		}

		return $this->application;
	}
}