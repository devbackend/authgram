/**
 * Управление приложением.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

(function ($) {
	/** @type {string} Селектор формы создания приложения */
	let SELECTOR_CREATE_APPLICATION_FORM = '[data-role="create-application-form"]';

	/** @type {string} Селектор контейнера с кнопкой "Отправить" */
	let SELECTOR_SUBMIT_CONTAINER = '[data-role="submit-container"]';

	/** @type {jQuery} Форма создания приложения */
	let $creationForm;

	/** @type {jQuery} Контеёнер с кнопкой отправки формы */
	let $submitContainer;

	$(function () {
		$creationForm    = $(SELECTOR_CREATE_APPLICATION_FORM);
		$submitContainer = $(SELECTOR_SUBMIT_CONTAINER);

		$creationForm.on('submit', function (e) {
			e.preventDefault();

			let formParams = $creationForm.serialize();
			let $errors = $creationForm.closest('.row').find('.errors ul');

			$.ajax({
				type: "POST",
				url: $creationForm.attr('action'),
				data: formParams,
				dataType: 'JSON',
				beforeSend: function() {
					$errors.html('');

					$submitContainer
						.find('button').addClass('hide')
						.end()
						.find('.progress').removeClass('hide')
					;
				},
				complete: function() {
					$submitContainer
						.find('button').removeClass('hide')
						.end()
						.find('.progress').addClass('hide')
					;
				},
				success: function(response){
					let $tokenMessage = $('<blockquote />')
						.html('<p>Идентификатор вашего приложения: <b>' + response.data.uuid + '</b></p>'
							+ '<p>Секреный ключ: <b>' + response.data.token + '</b></p>'
							+ '<p>Код виджета:<pre>' + response.text + '</pre></p>'
						)
					;
					let $formContainer = $('#creation-form');

					$formContainer
						.find(SELECTOR_CREATE_APPLICATION_FORM + ', .errors').remove()
						.end()
						.append($tokenMessage)
					;
				},
				error: function (response) {
					let responseJSON = response.responseJSON;
					for (let field in responseJSON) {
						if (false === responseJSON.hasOwnProperty(field)) {
							continue;
						}

						let errorText = responseJSON[field].pop();
						let $error    = $('<li>').addClass('red-text').text(errorText);

						$errors.append($error);
					}
				}
			});
		});
	});
}(jQuery));
