/**
 * Инициализация wysiwyg-редактора.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
(function($) {
	const SELECTOR_WYSIWYG = '[data-role="wysiwyg"]';

	$(function() {
		$(SELECTOR_WYSIWYG).trumbowyg({
			lang:       'ru',
			svgPath:    '/images/trumbowyg-icons.svg'
		});
	});
}(jQuery));