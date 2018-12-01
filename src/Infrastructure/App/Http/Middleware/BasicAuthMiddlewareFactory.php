<?php


namespace Infrastructure\App\Http\Middleware;

use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;
use App\Http\Middleware\BasicAuthMiddleware;

class BasicAuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new BasicAuthMiddleware($container->get('config')['auth']['users'], new Response());
    }
}
