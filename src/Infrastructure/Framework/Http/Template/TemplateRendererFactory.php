<?php


namespace Infrastructure\Framework\Http\Template;


use Psr\Container\ContainerInterface;
use Framework\Template\Twig\TwigRenderer;
use Twig\Environment;

class TemplateRendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TwigRenderer(
            $container->get(Environment::class),
            $container->get('config')['templates']['extension']
        );
    }
}