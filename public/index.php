<?php

### Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

### Autoload
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Action
$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse('Hello, ' . $name . '!'))
				->withHeader('X-Developer', 'Anton_T');

### Seeding
header('HTTP/1.0 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());

foreach ($response->getHeaders() as $name => $value) {
	header($name . ":" . implode(' ,', $value));
}

echo $response->getBody();