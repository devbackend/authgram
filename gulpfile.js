const elixir = require('laravel-elixir');

elixir(function(mix) {
	mix.webpack([
		'manage-application.js',
		'jquery.inputmask.bundle.js'
	]);

	mix.webpack(['broadcast.js'], 'public/js/widget-listener.js');

	mix.sass('resources/assets/sass/app.scss', 'public/css');
	mix.sass('resources/assets/sass/authorise-widget.scss', 'public/css/authorise-widget.css');
	mix.copy([
		'node_modules/materialize-css/dist/js/materialize.min.js',
		'node_modules/jquery/dist/jquery.min.js',
		'node_modules/materialize-css/dist/js/materialize.min.js'
	], 'public/js/');
});