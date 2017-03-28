<?php
/**
 * Шаблон для сгенерированного кода виджета
 *
 * @var Application $application Приложение
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

use App\Entities\Application;
?>

<button data-role="authgram-sign-button" class="authgram-sign-button"><span>Войти через Telegram</span></button>

<script type="text/javascript" src="https://cdn.authgram.ru/js/authgram-widget.js"></script>
<script type="text/javascript">
	var AuthGramWidget = new AuthGramWidget('<?= $application->uuid ?>');
</script>