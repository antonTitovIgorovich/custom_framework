<?php

use App\Http\Middleware\ResponseLoggerMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\CredentialsMiddleware;
use App\Http\Middleware\ProfilerMiddleware;

/** @var \Framework\Http\Application $app */

$app->pipe(ResponseLoggerMiddleware::class);
$app->pipe(ErrorHandlerMiddleware::class);
$app->pipe(CredentialsMiddleware::class);
$app->pipe(ProfilerMiddleware::class);
$app->pipe('/cabinet', BasicAuthMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe(DispatchMiddleware::class);