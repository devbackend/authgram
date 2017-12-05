process.env.DISABLE_NOTIFIER = true;

const elixir = require('laravel-elixir');
require('laravel-elixir-typescript');
require('laravel-elixir-replace');
require('laravel-elixir-env');

let authgramWidgetReplacements = [
	['%API_URL%', process.env.API_URL],
	['%BOT_NAME%', process.env.BOT_NAME],
];

elixir(function(mix) {
	mix.webpack([
		'manage-application.js',
		'website.js'
	]);

	mix.sass('resources/assets/sass/app.scss', 'public/css');

	mix.copy([
		'node_modules/materialize-css/dist/js/materialize.min.js',
		'node_modules/jquery/dist/jquery.min.js',
	], 'public/js/');

	mix.scripts('imask.js', 'public/js/imask.min.js');
	mix.scripts('notifications.js', 'public/js/notifications.min.js');

	mix.copy('resources/assets/fonts/', 'public/fonts/');
	mix.copy('resources/assets/images/', 'public/images/');

	//-- Генерация скриптов и стилей для виджета
	mix.typescript('authgram-widget.ts');
	mix.replace('public/js/authgram-widget.js', authgramWidgetReplacements);
	mix.sass('resources/assets/sass/authgram-widget.scss', 'public/css/authgram-widget.css');

	mix.webpack('authgram-listener.js', 'public/js/authgram-listener.js');
	//-- -- -- --

	// -- Сборка фронтенда для back-офиса
	/** @type {Array<string>} */
	let backOfficeStyleVendors = [
		'../../../node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css',
		'../../../node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css',
		'../../../node_modules/gentelella/vendors/iCheck/skins/flat/green.css',
		'../../../node_modules/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
		'../../../node_modules/gentelella/vendors/switchery/dist/switchery.min.css',
		'../../../node_modules/gentelella/vendors/dropzone/dist/min/dropzone.min.css',
		'../../../node_modules/gentelella/build/css/custom.min.css',
		'../../../node_modules/trumbowyg/dist/ui/trumbowyg.min.css',
	];

	/** @type {Array<string>} */
	let backOfficeScriptVendors = [
		'../../../node_modules/jquery/dist/jquery.min.js',
		'../../../node_modules/gentelella/vendors/jquery/dist/jquery.min.js',
		'../../../node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js',
		'../../../node_modules/gentelella/vendors/fastclick/lib/fastclick.js',
		'../../../node_modules/gentelella/vendors/nprogress/nprogress.js',
		'../../../node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js',
		'../../../node_modules/gentelella/vendors/bernii/gauge.js/dist/gauge.min.js',
		'../../../node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js',
		'../../../node_modules/gentelella/vendors/iCheck/icheck.min.js',
		'../../../node_modules/gentelella/vendors/skycons/skycons.js',
		'../../../node_modules/gentelella/vendors/Flot/jquery.flot.js',
		'../../../node_modules/gentelella/vendors/Flot/jquery.flot.pie.js',
		'../../../node_modules/gentelella/vendors/Flot/jquery.flot.time.js',
		'../../../node_modules/gentelella/vendors/Flot/jquery.flot.stack.js',
		'../../../node_modules/gentelella/vendors/switchery/dist/switchery.min.js',
		'../../../node_modules/gentelella/vendors/dropzone/dist/min/dropzone.min.js',
		'../../../node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js',
		'../../../node_modules/gentelella/vendors/raphael/raphael.min.js',
		'../../../node_modules/gentelella/vendors/morris.js/morris.min.js',
		'../../../node_modules/trumbowyg/dist/trumbowyg.min.js',
		'../../../node_modules/trumbowyg/dist/langs/ru.min.js',
		'../../../node_modules/gentelella/build/js/custom.min.js',
	];

	/** @type {Array<string>} */
	let backOfficeScripts = [
		'back-office/wysiwyg.js',
		'back-office/dashboard.js',
	];

	mix.styles(backOfficeStyleVendors, 'public/css/back-office.vendors.css');

	mix.scripts(backOfficeScriptVendors,    'public/js/back-office.vendors.js');
	mix.scripts(backOfficeScripts,          'public/js/back-office.app.js');

	mix.copy('node_modules/gentelella/vendors/font-awesome/fonts',  'public/fonts');
	mix.copy('node_modules/gentelella/vendors/bootstrap/fonts',     'public/fonts');

	mix.copy('node_modules/gentelella/vendors/iCheck/skins/flat/green.png',    'public/css');
	mix.copy('node_modules/gentelella/vendors/iCheck/skins/flat/green@2x.png', 'public/css');


	mix.copy('node_modules/trumbowyg/dist/ui/icons.svg', 'public/images/trumbowyg-icons.svg');
	// -- -- -- --
});