<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\ActionResolver;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$param = [
	'user' => ['admin' => 'password']
];

$aura = new Aura\Router\RouterContainer();
$routers = $aura->getMap();

$routers->get('home', '/', App\Action\IndexAction::class);
$routers->get('about', '/about', App\Action\AboutAction::class);
$routers->get('cabinet', '/cabinet',
	function(\Psr\Http\Message\ServerRequestInterface $request) use ($param){
		$auth = new App\Middleware\BasicAuthMiddleware($param['user']);
		$cabinet = new App\Action\CabinetAction();
		return $auth($request, function (\Psr\Http\Message\ServerRequestInterface $request) use ($cabinet){
			return $cabinet($request);
		});
	});
$routers->get('blog', '/blog', App\Action\Blog\IndexAction::class);
$routers->get('blog_show', '/blog/{id}', App\Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($aura);
$resolver = new ActionResolver();

### Running

$request = ServerRequestFactory::fromGlobals();

try {

	$result = $router->match($request);

	foreach ($result->getAttributes() as $attribute => $value) {
		$request = $request->withAttribute($attribute, $value);
	}
	$action = $resolver->resolve($result->getHandler());
	$response = $action($request);

} catch (RequestNotMatchedException $e) {
	$response = new HtmlResponse('Undefined Page', 404);
}

### PostProcessing

$response = $response->withHeader('X-dev', 'Titov');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);