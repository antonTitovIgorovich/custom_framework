<?php

use Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGeneratorFactory;
use Infrastructure\App\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Infrastructure\Framework\Http\Logger\LoggerFactory;
use Infrastructure\Framework\Http\ApplicationFactory;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;
use Framework\Http\Application;
use Psr\Log\LoggerInterface;
use Whoops\RunInterface;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,
            MiddlewareResolver::class => \Infrastructure\Framework\Http\Pipeline\MiddlewareResolverFactory::class,
            Router::class => \Infrastructure\Framework\Http\Router\RouterFactory::class,
            ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,
            ErrorResponseGenerator::class => PrettyErrorResponseGeneratorFactory::class,
            RunInterface::class => WhoopsErrorResponseGeneratorFactory::class,
            LoggerInterface::class => LoggerFactory::class,
        ]
    ],

    'debug' => false,
    'config_cache_enabled' => true
];




