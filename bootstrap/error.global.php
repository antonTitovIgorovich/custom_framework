<?php

use Framework\Http\Middleware\ErrorHandler\LogErrorListener;
use Whoops\RunInterface;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;
use Psr\Log\LoggerInterface;

return [
    'dependencies' => [
        'factories' => [

            ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                $middleware = new ErrorHandlerMiddleware($container->get(ErrorResponseGenerator::class));
                $middleware->addListener($container->get(LogErrorListener::class));
                return $middleware;
            },

            ErrorResponseGenerator::class => function (ContainerInterface $container) {

                return new PrettyErrorResponseGenerator(
                    $container->get(TemplateRenderer::class),
                    new Zend\Diactoros\Response(), [
                        403 => 'error/403',
                        404 => 'error/404',
                        'error' => 'error/error'
                    ]
                );
            },

            RunInterface::class => function () {
                $whoops = new Whoops\Run();
                $whoops->writeToOutput(false);
                $whoops->allowQuit(false);
                $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
                $whoops->register();
                return $whoops;
            },

            LoggerInterface::class => function (ContainerInterface $container) {
                $logger = new Monolog\Logger('App');
                $logger->pushHandler(new \Monolog\Handler\StreamHandler(
                    'var/log/application.log', \Monolog\Logger::WARNING
                ));
                return $logger;
            },
        ]
    ],

    'debug' => false,
];




