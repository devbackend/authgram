<?php

namespace App\Entities\Charts;

/**
 * Набор данных.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
class BarChartDataSet {
	/** @var string  */
	public $label = '';

	/** @var string */
	public $backgroundColor;

	/** @var int[]|float[] */
	public $data = [];
}