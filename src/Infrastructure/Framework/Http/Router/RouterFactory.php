<?php


namespace Infrastructure\Framework\Http\Router;

use Framework\Http\Router\AuraRouterAdapter;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;

class RouterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuraRouterAdapter(new RouterContainer());
    }
}
