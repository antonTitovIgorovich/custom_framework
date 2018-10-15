<?php


namespace Infrastructure\Framework\Http\Logger;


use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerDebugFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $logger = new Logger('App');
        $logger->pushHandler(new StreamHandler('var/log/application.log', Logger::DEBUG));
        return $logger;
    }
}