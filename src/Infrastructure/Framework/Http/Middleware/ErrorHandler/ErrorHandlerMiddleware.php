<?php


namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Psr\Container\ContainerInterface;
use Framework\Http\Middleware\ErrorHandler\LogErrorListener;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;

class ErrorHandlerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $middleware = new ErrorHandlerMiddleware($container->get(ErrorResponseGenerator::class));
        $middleware->addListener($container->get(LogErrorListener::class));
        return $middleware;
    }
}
