<?php


namespace Infrastructure\Framework\Console\Command;

use Psr\Container\ContainerInterface;
use App\Service\FileManager;
use App\Console\Command\CacheClearCommand;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CacheClearCommand(
            $container->get('config')['console']['cachePaths'], new FileManager
        );
    }
}