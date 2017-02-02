/**
 * Файл для работы с push-сообщениями сервера.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
import Echo from "laravel-echo";

window.Echo = new Echo({
	broadcaster: 'pusher',
	key: '19cdabf97bfb5b4f1e15',
	cluster: 'ap2',
	encrypted: true
});

window.Echo
	.channel('application-auth')
	.listen('UserJoined', (e) => {
		var user = e.user;

		document.writeln('<a href="https://web.telegram.org/#/im?p=@' + user.username + '">Telegram Profile of ' +
			user.first_name + ' ' + user.last_name +
			'</a>');
	});