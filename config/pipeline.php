<?php

use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Middleware\DispatchMiddleware;
use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\BasicAuthMiddleware;

/** @var \Framework\Http\Application $app */

$app->pipe(ErrorHandlerMiddleware::class);
$app->pipe(App\Middleware\CredentialsMiddleware::class);
$app->pipe(App\Middleware\ProfilerMiddleware::class);
$app->pipe('/cabinet', BasicAuthMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe(DispatchMiddleware::class);