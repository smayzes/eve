<?php

return [
    'auth' => [
        'token' => env('EVE_SLACK_TOKEN'),
    ],

    'handlers' => [
        App\Handlers\Fun\PunHandler::class,
        App\Handlers\Fun\SandwichHandler::class,
        App\Handlers\Human\HelloHandler::class,
        App\Handlers\Human\ThanksHandler::class,
        App\Handlers\Utility\PingHandler::class,
    ],
];
