<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Framework\Http\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response;

/**
 * @var Framework\Http\Application $app
 * @var Framework\Container\Container $container
 */

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';
$app = $container->get(Application::class);

require 'config/pipeline.php';
require 'config/routes.php';

$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request, new Response());

$emitter = new SapiEmitter();
$emitter->emit($response);