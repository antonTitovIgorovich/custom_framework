<?php

namespace Framework\Template\Php\Extension;

use Framework\Http\Router\Router;
use Framework\Template\Php\Extension;
use Framework\Template\Php\SimpleFunction;
use Framework\Template\PhpRenderer;

class RouteExtension extends Extension
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new SimpleFunction('path', [$this, 'generatePath'], true),
        ];
    }

    public function generatePath(PhpRenderer $renderer, $name, array $params = []): string
    {
        if (isset($params['encode']) && $params['encode']){
            unset($params['encode']);
            return $renderer->encode($this->router->generate($name, $params));
        }
        return $this->router->generate($name, $params);
    }
}