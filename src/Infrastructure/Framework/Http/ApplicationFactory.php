<?php


namespace Infrastructure\Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Application;
use Framework\Http\Router\Router;
use App\Http\Middleware\NotFoundHandler;
use Psr\Container\ContainerInterface;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return (new Application(
            $container->get(MiddlewareResolver::class),
            $container->get(Router::class),
            $container->get(NotFoundHandler::class)
        ));
    }
}
