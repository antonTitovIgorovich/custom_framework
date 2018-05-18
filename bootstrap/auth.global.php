<?php

use App\Http\Middleware\BasicAuthMiddleware;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function ($container){
                return new BasicAuthMiddleware($container->get('config')['auth']['users']);
            },
        ],
    ],

    'auth' => [
        'users' => [],
    ]
];




