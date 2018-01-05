<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;


chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$routes = new RouteCollection();

$routes->get('home', '/', function (ServerRequestInterface $request) {
	$name = $request->getQueryParams()['name'] ?? 'Guest';
	return new HtmlResponse('Hello, ' . $name . '!');
});

$routes->get('about', '/about', function (){
	return new HtmlResponse('I am simple suite');
});

$routes->get('blog', '/blog', function () {
	return new JsonResponse([
		['id' => 2, 'title' => 'The Second Post'],
		['id' => 1, 'title' => 'The First Post']
	]);
});

$routes->get('blog_show', '/blog/{id}', function (ServerRequestInterface $request){
	$id = $request->getAttribute('id');
	if ($id > 2){
		return new HtmlResponse('Undefined Page', 404);
	}
	return new JsonResponse(['id'=> $id, 'title' => "Post # $id"]);
}, ['id' => '\d+']);

$router = new Router($routes);
### Running

$request = ServerRequestFactory::fromGlobals();
try{
	$result = $router->match($request);
	foreach ($result->getAttributes() as $attribute => $value){
		$request = $request->withAttribute($attribute, $value);
	}
	$action = $result->getHandler();
	$response = $action($request);
}catch (RequestNotMatchedException $e){
	$response = new HtmlResponse('Undefined Page', 404);
}

### PostProcessing

$response = $response->withHeader('X-dev', 'Tito');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);