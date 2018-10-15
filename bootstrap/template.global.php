<?php

use Framework\Template\TemplateRenderer;
use Infrastructure\Framework\Http\Template\TemplateRendererFactory;
use Infrastructure\Framework\Http\Template\TwigEnvFactory;

return [
    'dependencies' => [
        'factories' => [
            TemplateRenderer::class => TemplateRendererFactory::class,
            Twig\Environment::class => TwigEnvFactory::class
        ]
    ],

    'templates' => [
        'extension' => '.html.twig'
    ],

    'twig' => [
        'template_dir' => 'templates',
        'cache_dir' => 'var/cache/twig',
        'extensions' => []
    ]
];




