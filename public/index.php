<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Middleware\DispatchMiddleware;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\BasicAuthMiddleware;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Configuration

$container = new Framework\Container\Container();

$container->set('config', [
    'debug' => true,
    'user' => ['admin' => 'password'],
    'basePath' => '/frame'
]);

$container->set(MiddlewareResolver::class, function (){
    return new MiddlewareResolver();
});

$container->set(ErrorHandlerMiddleware::class, function ($container){
    return new App\Middleware\ErrorHandlerMiddleware($container->get('config')['debug']);
});

$container->set(BasicAuthMiddleware::class, function ($container){
    return new App\Middleware\BasicAuthMiddleware($container->get('config')['user']);
});

$container->set(Router::class, function ($container){
    $aura = new Aura\Router\RouterContainer($container->get('config')['basePath'] ?? null);
    $routers = $aura->getMap();

    $routers->get('home', '/', App\Action\IndexAction::class);
    $routers->get('about', 'about', App\Action\AboutAction::class);
    $routers->get('cabinet', '/cabinet', App\Action\CabinetAction::class);
    $routers->get('blog', '/blog', App\Action\Blog\IndexAction::class);
    $routers->get('blog_show', '/blog/{id}', App\Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

    return new AuraRouterAdapter($aura);
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
        new App\Middleware\NotFoundHandler(),
        new Response()
    );
    $app->withBasePath($container->get('config')['basePath'] ?? null);

    return $app;
});

### Initialization

/** @var Application $app */
$app = $container->get(Application::class);

$app->pipe($container->get(ErrorHandlerMiddleware::class));
$app->pipe(App\Middleware\ProfilerMiddleware::class);
$app->pipe(App\Middleware\CredentialsMiddleware::class);
$app->pipe('cabinet', $container->get(BasicAuthMiddleware::class));
$app->pipe($container->get(RouteMiddleware::class));
$app->pipe($container->get(DispatchMiddleware::class));

### Running

$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request, new Response());

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);