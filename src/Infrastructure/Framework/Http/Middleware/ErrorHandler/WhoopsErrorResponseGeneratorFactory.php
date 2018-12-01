<?php


namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Psr\Container\ContainerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $whoops = new Run();
        $whoops->writeToOutput(false);
        $whoops->allowQuit(false);
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();
        return $whoops;
    }
}
