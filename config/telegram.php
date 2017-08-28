<?php

$commandList = [
	\App\Console\Commands\Telegram\AddApplicationCommand::class,
	\App\Console\Commands\Telegram\CheckCodeCommand::class,
	\App\Console\Commands\Telegram\HelpCommand::class,
	\App\Console\Commands\Telegram\StartCommand::class,
	\App\Console\Commands\Telegram\OnNotificationCommand::class,
	\App\Console\Commands\Telegram\OffNotificationCommand::class,
];

$cachedAuthCommands = (file_exists(base_path('app/Console/Commands/Telegram/AuthoriseCommands/cached.php'))
	? require base_path('app/Console/Commands/Telegram/AuthoriseCommands/cached.php')
	: []
);

return [
    /*
    |--------------------------------------------------------------------------
    | Telegram Bot API Access Token [REQUIRED]
    |--------------------------------------------------------------------------
    |
    | Your Telegram's Bot Access Token.
    | Example: 123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
    |
    | Refer for more details:
    | https://core.telegram.org/bots#botfather
    |
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Asynchronous Requests [Optional]
    |--------------------------------------------------------------------------
    |
    | When set to True, All the requests would be made non-blocking (Async).
    |
    | Default: false
    | Possible Values: (Boolean) "true" OR "false"
    |
    */
    'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Handler [Optional]
    |--------------------------------------------------------------------------
    |
    | If you'd like to use a custom HTTP Client Handler.
    | Should be an instance of \Telegram\Bot\HttpClients\HttpClientInterface
    |
    | Default: GuzzlePHP
    |
    */
    'http_client_handler' => null,

    /*
    |--------------------------------------------------------------------------
    | Register Telegram Commands [Optional]
    |--------------------------------------------------------------------------
    |
    | If you'd like to use the SDK's built in command handler system,
    | You can register all the commands here.
    |
    | The command class should extend the \Telegram\Bot\Commands\Command class.
    |
    | Default: The SDK registers, a help command which when a user sends /help
    | will respond with a list of available commands and description.
    |
    */
    'commands' => array_merge($commandList, $cachedAuthCommands),
];
