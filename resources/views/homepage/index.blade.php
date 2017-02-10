<?php
/**
 * Шаблон главной страницы приложения.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

?>

@extends('layouts.frontend')

@section('content')
	<h1>Авторизация при помощи Telegram</h1>

	<p>
		Больше не надо запоминать длинных паролей и логинов, а также бояться что ваши данные попадут в руки хакеров при взломе сайта.
		Теперь все что вам необходимо, это подтвердить что Вы это Вы при помощи бота для авторизации, отправив ему сообщение.
		И после этого вы автоматически становитесь не анонимным гостем на сайте, а полноценным его посетителем.
	</p>

	@include('homepage._blocks.api-description')
@endsection

@push('scripts')
<script type="application/javascript" src="/js/all.js"></script>
@endpush