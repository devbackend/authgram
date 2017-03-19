<?php
/**
 * Шаблон для статичной страницы
 *
 * @var string $page Название страницы
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
?>

@extends('layouts.frontend')

@section('content')
	<div class="page-block">
		@include('pages.page-content.' . $page)
	</div>
@endsection