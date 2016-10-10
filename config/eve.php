<?php

return [
    'auth' => [
        'token' => env('EVE_SLACK_TOKEN'),
    ],

    'handlers' => [
        App\Handlers\Human\HelloHandler::class,
    ],
];
