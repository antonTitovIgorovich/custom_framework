<?php

use Whoops\RunInterface;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;

return [
    'dependencies' => [
        'factories' => [

            ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                return new ErrorHandlerMiddleware(
                    $container->get(ErrorResponseGenerator::class)
                );
            },

            ErrorResponseGenerator::class => function (ContainerInterface $container) {

                if ($container->get('config')['debug']) {
                    return new WhoopsErrorResponseGenerator(
                        $container->get(RunInterface::class),
                        new Zend\Diactoros\Response()
                    );
                }

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
        ]
    ],

    'debug' => false,
];




