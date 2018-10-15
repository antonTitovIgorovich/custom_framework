<?php

use App\Http\Middleware\BasicAuthMiddleware;
use Infrastructure\App\Http\Middleware\BasicAuthMiddlewareFactory;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => BasicAuthMiddlewareFactory::class,
        ],
    ],

    'auth' => [
        'users' => [],
    ]
];




