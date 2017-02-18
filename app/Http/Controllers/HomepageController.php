<?php
namespace App\Http\Controllers;

use App\Entities\Owner;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Контролер главной страницы.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class HomepageController extends Controller {
	const REQUEST_PARAM_AUTH_KEY = 'auth_key';

	/**
	 * Реализация основной логики контроллера.
	 *
	 * @param Request $request Входящий запрос
	 *
	 * @return View
	 *
	 * @author Кривонос Иван <devbackend@yandex.ru>
	 */
	public function __invoke(Request $request) {
		if ($request->has(static::REQUEST_PARAM_AUTH_KEY)) {
			$authKey = $request->get(static::REQUEST_PARAM_AUTH_KEY);
			$owner = Owner::where(Owner::PASSWORD, $authKey)->first();
			if (null !== $owner) {
				Auth::login($owner);
			}

			return redirect()->route(RouteServiceProvider::ROUTE_NAME_HOMEPAGE);
		}

		return $this->render('index');
	}
}