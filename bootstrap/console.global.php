<?php

use App\Console\Command;
use App\Service\FileManager;

return [
    'dependencies' => [
        'factories' => [
            Command\CacheClearCommand::class => function (\Psr\Container\ContainerInterface $container) {
                return new Command\CacheClearCommand(
                    $container->get('config')['console']['cachePaths'], new FileManager
                );
            }
        ]
    ],

    'console' => [
        'cachePaths' => [
            'twig' => 'var/cache/twig'
        ]
    ],
];
