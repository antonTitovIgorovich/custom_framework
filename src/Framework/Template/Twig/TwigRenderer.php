<?php

namespace Framework\Template\Twig;

use Framework\Template\TemplateRenderer;

use Twig\Environment;

class TwigRenderer implements TemplateRenderer
{
    private $environment;
    private $extension;

    public function __construct(Environment $environment, string $extension)
    {
        $this->environment = $environment;
        $this->extension = $extension;
    }

    public function render(string $view, array $params = []): string
    {
        return $this->environment->render($view . $this->extension, $params);
    }
}
