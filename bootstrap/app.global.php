<?php

use App\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Whoops\RunInterface;
use Zend\Diactoros\Response;
use App\Http\Middleware\NotFoundHandler;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use App\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use App\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;
use App\Http\Middleware\ErrorHandler\DebugErrorGenerator;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return (new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    $container->get(NotFoundHandler::class)
                ));
            },

            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container, new Response());
            },

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

            Router::class => function () {
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },
        ]
    ],

    'debug' => false,
];




