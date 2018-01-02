<?php

### Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

### Autoload
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Action
$path = $request->getUri()->getPath();

$response = (new HtmlResponse('Path is ' . $path))
			->withHeader('X-Developer', 'Anton_T');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);