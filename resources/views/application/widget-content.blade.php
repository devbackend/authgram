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

<div data-role="authgram-bot" class="authgram-widget"></div>

<script type="text/javascript" src="https://cdn.authgram.ru/js/authgram-widget.js"></script>
<script type="text/javascript">
	var AuthGramWidget = new AuthGramWidget('<?= $application->uuid ?>');
</script>