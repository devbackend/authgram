/**
 * Прослушка канала уведомлений авторизации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
import Echo from "laravel-echo";

//-- Подключаем слушатель событий на сокетах
window.Echo = new Echo({
	broadcaster: 'pusher',
	key: '19cdabf97bfb5b4f1e15',
	cluster: 'ap2',
	encrypted: true
});
//-- -- -- --
