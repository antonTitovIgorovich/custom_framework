<?php


namespace Infrastructure\Framework\Http\Middleware;


use Psr\Container\ContainerInterface;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Whoops\RunInterface;
use Zend\Diactoros\Response;

class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new WhoopsErrorResponseGenerator($container->get(RunInterface::class), new Response());
    }
}