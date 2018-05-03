<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\MiddlewareResolver;
use Framework\Http\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$param = [
	'debug' => true,
	'user' => ['admin' => 'password']
];

$aura = new Aura\Router\RouterContainer();
$routers = $aura->getMap();

$routers->get('home', '/', App\Action\IndexAction::class);
$routers->get('about', '/about', App\Action\AboutAction::class);
$routers->get('cabinet', '/cabinet',
	[
		new App\Middleware\BasicAuthMiddleware($param['user']),
		App\Action\CabinetAction::class
	]);
$routers->get('blog', '/blog', App\Action\Blog\IndexAction::class);
$routers->get('blog_show', '/blog/{id}', App\Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($aura);

$resolver = new MiddlewareResolver();
$app = new Application($resolver, new App\Middleware\NotFoundHandler());
$app->pipe(new App\Middleware\ErrorHandlerMiddleware($param['debug']));
$app->pipe(App\Middleware\ProfilerMiddleware::class);
$app->pipe(App\Middleware\CredentialsMiddleware::class);

### Running

$request = ServerRequestFactory::fromGlobals();

try {
	$result = $router->match($request);
	foreach ($result->getAttributes() as $attribute => $value) {
		$request = $request->withAttribute($attribute, $value);
	}

	$app->pipe($result->getHandler());

} catch (RequestNotMatchedException $e) {
}

$response = $app->run($request);

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);