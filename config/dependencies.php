<?php

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Framework\Container\Container;
use Zend\Diactoros\Response;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\BasicAuthMiddleware;

return [
    Application::class => function (Container $container){
        $app = new Application(
            $container->get(MiddlewareResolver::class),
            $container->get(Router::class),
            new App\Middleware\NotFoundHandler(),
            new Response()
        );
        $app->basePath($container->get('config')['basePath'] ?? null);

        return $app;
    },

    MiddlewareResolver::class => function (Container $container){
        return new MiddlewareResolver($container);
    },

    ErrorHandlerMiddleware::class => function (Container $container){
        return new App\Middleware\ErrorHandlerMiddleware($container->get('config')['debug']);
    },

    BasicAuthMiddleware::class => function (Container $container){
        return new App\Middleware\BasicAuthMiddleware($container->get('config')['user']);
    },

    Router::class => function (){
        return new AuraRouterAdapter(new Aura\Router\RouterContainer());
    }
];




