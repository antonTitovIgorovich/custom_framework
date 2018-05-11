<?php

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Middleware\DispatchMiddleware;
use Zend\Diactoros\Response;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\BasicAuthMiddleware;

$container->set(MiddlewareResolver::class, function (){
    return new MiddlewareResolver();
});

$container->set(ErrorHandlerMiddleware::class, function ($container){
    return new App\Middleware\ErrorHandlerMiddleware($container->get('config')['debug']);
});

$container->set(BasicAuthMiddleware::class, function ($container){
    return new App\Middleware\BasicAuthMiddleware($container->get('config')['user']);
});

$container->set(Router::class, function (){
    return new AuraRouterAdapter(new Aura\Router\RouterContainer());
});

$container->set(RouteMiddleware::class, function ($container){
    return new RouteMiddleware($container->get(Router::class));
});

$container->set(DispatchMiddleware::class, function ($container){
    return new DispatchMiddleware($container->get(MiddlewareResolver::class));
});

$container->set(Application::class, function ($container){
    $app = new Application(
        $container->get(MiddlewareResolver::class),
        $container->get(Router::class),
        new App\Middleware\NotFoundHandler(),
        new Response()
    );
    $app->basePath($container->get('config')['basePath'] ?? null);

    return $app;
});