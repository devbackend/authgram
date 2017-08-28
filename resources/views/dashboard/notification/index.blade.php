@extends('layouts.frontend')

@section('content')
	<div class="div">
		<div class="col s12">
			<div class="row">
				<h1>Отправка уведомлений</h1>

				<div class="progress hide" data-role="preloader">
					<div class="indeterminate"></div>
				</div>

				<div class="input-field col s12">
					<textarea name="notification_text" id="notification_text" class="materialize-textarea"></textarea>
					<label for="notification_text">Текст уведомления</label>
				</div>

				<div class="row">
					<div class="input-field col s6 center-align">
						<button class="btn waves-effect waves-light" data-role="text-send" data-url="<?= action('Dashboard\NotificationController@testSendAction') ?>">Протестировать
							<i class="material-icons right">done</i>
						</button>
					</div>

					<div class="input-field col s6 center-align">
						<button class="btn waves-effect waves-light" data-role="real-send" data-url="<?= action('Dashboard\NotificationController@realSendAction') ?>" disabled>Отправить всем
							<i class="material-icons right">done_all</i>
						</button>
					</div>
				</div>
			</div>

			<div data-role="result">

			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript" src="/js/notifications.min.js"></script>
@endpush