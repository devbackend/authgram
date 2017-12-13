/**
 * Скрипты для отправки уведомлений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
(function(window, $) {
	var SELECTOR_NOTIFICATION_TEXT = '#notification_text';

	var SELECTOR_TEST_SEND_BUTTON = '[data-role="text-send"]';
	var SELECTOR_REAL_SEND_BUTTON = '[data-role="real-send"]';

	$(function () {
		var $textarea   = $(SELECTOR_NOTIFICATION_TEXT);
		var $testButton = $(SELECTOR_TEST_SEND_BUTTON);
		var $realButton = $(SELECTOR_REAL_SEND_BUTTON);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$testButton.on('click', function() {
			$.ajax({
				type: "POST",
				url: $testButton.data('url'),
				data: {text: $textarea.val()},
				dataType: 'JSON',
				success: function(response) {
					if (false === response.success) {
						alert(response.error);

						return;
					}

					$realButton.prop('disabled', false);
				},
				error: function (response) {
					alert(response);
				}
			});
		});

		$realButton.on('click', function() {
			$.ajax({
				type: "POST",
				url: $realButton.data('url'),
				data: {text: $textarea.val()},
				dataType: 'JSON',
				success: function() {
					$realButton.prop('disabled', true);
				},
				error: function (response) {
					alert(response);
				}
			});
		});
	});
}(window, jQuery));