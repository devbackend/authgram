<?php
/**
 * Список каналов для передачи информации.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */

Broadcast::channel('application-auth', function($user) {
	return true;
});