<?php

namespace App\Http;

use App\Http\Middleware\CheckAuthKey;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel {
	const MIDDLEWARE_ALIAS_AUTH         = 'auth';
	const MIDDLEWARE_ALIAS_AUTH_BASIC   = 'auth.basic';
	const MIDDLEWARE_ALIAS_BINDINGS     = 'bindings';
	const MIDDLEWARE_ALIAS_CAN          = 'can';
	const MIDDLEWARE_ALIAS_GUEST        = 'guest';
	const MIDDLEWARE_ALIAS_THROTTLE     = 'throttle';

	const MIDDLEWARE_GROUP_API = 'api';
	const MIDDLEWARE_GROUP_WEB = 'web';

	/** @var string[] Список глобальных middleware приложения. Исполняются в любом запросе к приложению. */
	protected $middleware = [
		CheckForMaintenanceMode::class,
	];

	/** @var string[][] Группы middleware */
	protected $middlewareGroups = [
		self::MIDDLEWARE_GROUP_WEB => [
			EncryptCookies::class,
			AddQueuedCookiesToResponse::class,
			StartSession::class,
			ShareErrorsFromSession::class,
			VerifyCsrfToken::class,
			SubstituteBindings::class,
			CheckAuthKey::class,
		],

		self::MIDDLEWARE_GROUP_API => [
			self::MIDDLEWARE_ALIAS_THROTTLE . ':60,1',
			self::MIDDLEWARE_ALIAS_BINDINGS,
		],
	];

	/** @var string[] Список middleware для использования в роутах. */
	protected $routeMiddleware = [
		self::MIDDLEWARE_ALIAS_AUTH       => Authenticate::class,
		self::MIDDLEWARE_ALIAS_AUTH_BASIC => AuthenticateWithBasicAuth::class,
		self::MIDDLEWARE_ALIAS_BINDINGS   => SubstituteBindings::class,
		self::MIDDLEWARE_ALIAS_CAN        => Authorize::class,
		self::MIDDLEWARE_ALIAS_GUEST      => RedirectIfAuthenticated::class,
		self::MIDDLEWARE_ALIAS_THROTTLE   => ThrottleRequests::class,
	];
}
