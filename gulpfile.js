const elixir = require('laravel-elixir');
require('laravel-elixir-typescript');
require('laravel-elixir-replace');
require('laravel-elixir-env');

let authgramWidgetReplacements = [
	['API_URL', process.env.API_URL],
	['BOT_NAME', process.env.BOT_NAME],
];

elixir(function(mix) {
	mix.webpack([
		'manage-application.js',
		'website.js'
	]);

	mix.scripts('scrollIt.js', 'public/js/scrollIt.min.js');

	mix.sass('resources/assets/sass/app.scss', 'public/css');

	mix.copy([
		'node_modules/materialize-css/dist/js/materialize.min.js',
		'node_modules/jquery/dist/jquery.min.js',
	], 'public/js/');

	mix.copy('resources/assets/fonts/', 'public/fonts/');
	mix.copy('resources/assets/images/', 'public/images/');

	//-- Генерация скриптов и стилей для виджета
	mix.typescript('authgram-widget.ts');
	mix.webpack('authgram-listener.js', 'public/js/authgram-listener.js');
	mix.sass('resources/assets/sass/authgram-widget.scss', 'public/css/authgram-widget.css');

	mix.replace('public/js/authgram-widget.js', authgramWidgetReplacements);
	//-- -- -- --
});