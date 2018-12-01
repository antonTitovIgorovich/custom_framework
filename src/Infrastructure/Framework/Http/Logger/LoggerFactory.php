<?php


namespace Infrastructure\Framework\Http\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerFactory
{
    public function __invoke()
    {
        $logger = new Logger('App');
        $logger->pushHandler(new StreamHandler(
            'var/log/application.log',
            Logger::WARNING
        ));
        return $logger;
    }
}
