<?php

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Zend\Diactoros\Response;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use Framework\Template\TemplateRenderer;
use Framework\Template\PhpRenderer;

return [
    'dependencies' => [
        'abstract_factories' => [
            Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => function ($container){
                $app = new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    $container->get(NotFoundHandler::class),
                    new Response()
                );
                $app->withBasePath($container->get('config')['basePath'] ?? null);

                return $app;
            },

            MiddlewareResolver::class => function ($container){
                return new MiddlewareResolver($container);
            },

            ErrorHandlerMiddleware::class => function ($container){
                return new ErrorHandlerMiddleware(
                    $container->get(TemplateRenderer::class),
                    $container->get('config')['debug']
                );
            },

            Router::class => function (){
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },

            TemplateRenderer::class => function($container) {
                return new PhpRenderer('templates', $container->get(Router::class));
            }
        ]
    ],

    'debug' => false,
    /** 'basePath' => null|'/some'  */
    'basePath' => null,
];




