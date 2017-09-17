/**
 * Скрипты для отправки уведомлений.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
(function(window, $) {
	var SELECTOR_NOTIFICATION_TEXT = '#notification_text';

	var SELECTOR_TEST_SEND_BUTTON = '[data-role="text-send"]';
	var SELECTOR_REAL_SEND_BUTTON = '[data-role="real-send"]';

	var SELECTOR_PRELOADER = '[data-role="preloader"]';

	$(function () {
		var $textarea   = $(SELECTOR_NOTIFICATION_TEXT);
		var $testButton = $(SELECTOR_TEST_SEND_BUTTON);
		var $realButton = $(SELECTOR_REAL_SEND_BUTTON);
		var $preloader  = $(SELECTOR_PRELOADER);

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
				beforeSend: function() {
					$preloader.toggleClass('hide', false);
				},
				complete: function() {
					$preloader.toggleClass('hide', true);
				},
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
				beforeSend: function() {
					$preloader.toggleClass('hide', false);
				},
				complete: function() {
					$preloader.toggleClass('hide', true);
				},
				success: function(response) {
					$('[data-role="result"]').html('<p><b>Успешно отправлено:</b> ' + response.successCount + '</p><p><b>Не отправлено:</b> ' + response.errorsCount + '</p>');
					$textarea.val('');
					$realButton.prop('disabled', true);
				},
				error: function (response) {
					alert(response);
				}
			});
		});
	});
}(window, jQuery));