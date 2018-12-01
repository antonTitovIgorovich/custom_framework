<?php


namespace Infrastructure\App\Http\Middleware\ErrorHandler;

use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;
use Zend\Diactoros\Response;

class PrettyErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PrettyErrorResponseGenerator(
            $container->get(TemplateRenderer::class),
            new Response(),
            [
                403 => 'error/403',
                404 => 'error/404',
                'error' => 'error/error'
            ]
        );
    }
}