<?php

use App\Middleware\BasicAuthMiddleware;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function ($container){
                return new App\Middleware\BasicAuthMiddleware($container->get('config')['auth']['users']);
            },
        ],
    ],

    'auth' => [
        'users' => [],
    ]
];




