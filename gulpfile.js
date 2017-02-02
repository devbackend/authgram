/**
 *
 *
 * @author: Кривонос Иван <krivonos.iv@dns-shop.ru>
 */

const elixir = require('laravel-elixir');

elixir(function(mix) {
	mix.webpack(['broadcast.js']);
});