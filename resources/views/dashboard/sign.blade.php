@extends('layouts.frontend')

@section('content')
	<div id="telegram-auth-widget" class="telegram-auth-widget"></div>

	@push('scripts')
	<script type="text/javascript" src="<?= env('API_URL') ?>/js/authgram-widget.js"></script>
	<script type="text/javascript">
		new AuthGramWidget('157bb070-eaee-11e6-84e2-0f2ab592a536', {
			selector: '#telegram-auth-widget',
			onAuthSuccess: function (authKey) {
				document.location.href = '/dashboard?auth_key=' + authKey;
			}
		});
	</script>
	@endpush
@endsection