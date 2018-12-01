<?php

use Infrastructure\Framework\Console\Command\CacheClearCommandFactory;
use App\Console\Command\CacheClearCommand;

return [
    'dependencies' => [
        'factories' => [
            CacheClearCommand::class => CacheClearCommandFactory::class
        ]
    ],

    'console' => [

        'commands' => [
            CacheClearCommand::class,
        ],

        'cachePaths' => [
            'twig' => 'var/cache/twig'
        ]
    ],
];
