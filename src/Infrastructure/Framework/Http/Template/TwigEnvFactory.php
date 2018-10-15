<?php


namespace Infrastructure\Framework\Http\Template;


use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Framework\Template\Twig\Extension\RouteExtension;
use Twig\Extension\DebugExtension;

class TwigEnvFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['twig'];
        $debug = $container->get('config')['debug'];

        $loader = new FilesystemLoader();
        $loader->addPath($config['template_dir']);

        $environment = new Environment($loader, [
            'cache' => $debug ? false : $config['cache_dir'],
            'debug' => $debug,
            'strict_variables' => $debug,
            'auto_reload' => $debug
        ]);

        if ($debug){
            $environment->addExtension(new DebugExtension());
        }

        $environment->addExtension($container->get(RouteExtension::class));

        foreach ($config['extensions'] as $extension){
            $environment->addExtension($container->get($extension));
        }

        return $environment;
    }
}