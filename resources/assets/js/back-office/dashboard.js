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

		var ctx  = document.getElementById("users-and-messages");

		new Chart(ctx, {
			type: 'bar',
			data: window.charts.usersAndMessages,

			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
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
			ykeys: [0, 1, 2, 3],
			lineColors: ['#1976d2', '#0d47a1', '#c62828', '#00695c'],
			labels: ['Код', 'Команда', 'Успех', 'Неудача'],
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