<?php

namespace App\Http\Requests\application;

use App\Entities\Application;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Базовый запрос для управления приложением.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
abstract class ApplicationRequest extends FormRequest {
	/**
	 * Имеет ли текущий пользователь право на отправку запроса.
	 *
	 * @return bool
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function authorize() {
		return Auth::check();
	}

	/**
	 * Правила валидации.
	 *
	 * @return string[]
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function rules() {
		return [
			Application::TITLE              => 'required|min:5',
			Application::WEBSITE            => 'required|url|unique:' . Application::table(),
			Application::AUTH_REQUEST_URL   => 'required|url',
		];
	}

	/**
	 * @inheritdoc
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function all() {
		$attributes = parent::all();

		$attributes[Application::WEBSITE] = strtolower($attributes[Application::WEBSITE]);

		return $attributes;
	}
}