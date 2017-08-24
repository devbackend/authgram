/**
 * Прослушка канала уведомлений авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
import Echo from "laravel-echo";

function AuthgramListener() {
	var pusher;

	var pusherConfig = {
		broadcaster: 'pusher',
		key: '19cdabf97bfb5b4f1e15',
		cluster: 'ap2',
		encrypted: true
	};

	this.getPusher = function() {
		if (undefined === pusher) {
			pusher = new Echo(pusherConfig);
		}

		return pusher;
	};
}

//-- Подключаем слушатель событий на сокетах
window.AuthgramListener = new AuthgramListener();
//-- -- -- --
