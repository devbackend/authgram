/**
 * Скрипты для работы с меню.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
(function ($) {
	$(function () {
		$('[data-role="developers-faq"]').collapsible();

		$(".button-collapse").sideNav();

		$('[data-role="mobile-menu"]').sideNav({
			menuWidth: 300, // Default is 300
			edge: 'left', // Choose the horizontal origin
			closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
			draggable: true // Choose whether you can drag to open on touch screens
		});
	});
}(jQuery));