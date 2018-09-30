<?php

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Zend\Diactoros\Response;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container){
                return (new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    $container->get(NotFoundHandler::class)
                ));
            },

            MiddlewareResolver::class => function (ContainerInterface $container){
                return new MiddlewareResolver($container, new Response());
            },

            ErrorHandlerMiddleware::class => function (ContainerInterface $container){
                return new ErrorHandlerMiddleware(
                    $container->get('config')['debug'],
                    $container->get(TemplateRenderer::class)
                );
            },

            Router::class => function (){
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },
        ]
    ],

    'debug' => false,
];




