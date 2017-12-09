/**
 * Главная страница панели управления.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
(function($, window) {
	function initUsersChart() {
		if (undefined === window.charts || undefined === window.charts.usersAndMessages) {
			return;
		}

		Morris.Area({
			element: 'users-and-messages',
			data: window.charts.usersAndMessages,
			xkey: 'period',
			ykeys: ['users', 'messages'],
			lineColors: ['#2e7d32', '#1565c0'],
			labels: ['Пользователи', 'Сообщения'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
	}

	function initAuthStats() {
		if (undefined === window.charts || undefined === window.charts.authStats) {
			return;
		}

		Morris.Area({
			element: 'auth-stat',
			data: window.charts.authStats,
			xkey: 'period',
			ykeys: [2, 3],
			lineColors: ['#c62828', '#00695c'],
			labels: ['Успех', 'Неудача'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
	}

	$(function() {
		initUsersChart();
		initAuthStats();
	});
}(jQuery, window));