<?php

namespace App\Entities\Charts;

/**
 * Класс описания данных для графиков-столбиков.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class BarChart {
	/** @var string[] */
	public $labels = [];

	/** @var BarChartDataSet[] */
	public $datasets = [];
}