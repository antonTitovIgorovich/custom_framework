<?php

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Infrastructure\Framework\Http\ApplicationFactory;
use Zend\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Infrastructure\Framework\Http\Logger\LoggerFactory;
use Infrastructure\App\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGeneratorFactory;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Psr\Log\LoggerInterface;
use Whoops\RunInterface;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,

            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container, new Response());
            },

            Router::class => function () {
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },

            ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,
            ErrorResponseGenerator::class => PrettyErrorResponseGeneratorFactory::class,
            RunInterface::class => WhoopsErrorResponseGeneratorFactory::class,
            LoggerInterface::class => LoggerFactory::class,
        ]
    ],
];




