const elixir = require('laravel-elixir');

elixir(function(mix) {
	mix.copy('node_modules/material-design-lite/material.min.css', 'public/css/material.min.css');
	mix.copy('node_modules/material-design-lite/material.min.js', 'public/js/material.min.js');
});