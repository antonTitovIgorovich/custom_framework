<?php


namespace Infrastructure\Framework\Http\Pipeline;


use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;
use Framework\Http\Pipeline\MiddlewareResolver;

class MiddlewareResolverFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MiddlewareResolver($container, new Response());
    }
}