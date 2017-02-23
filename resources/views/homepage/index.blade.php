<?php
/**
 * Шаблон главной страницы приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

$homepageBlocks = ['about', 'add', 'dev'];
?>

@extends('layouts.frontend')

@section('content')
	<div class="page-blocks">
		<?php foreach ($homepageBlocks as $index => $homepageBlock): ?>
			<div class="page-block" data-scroll-index="<?= $index ?>">
				@include('homepage._blocks.' . $homepageBlock)
			</div>
		<?php endforeach ?>
	</div>

	{{--@include('homepage._blocks.api-description')--}}
@endsection

@push('scripts')
<script type="application/javascript" src="/js/all.js"></script>
@endpush