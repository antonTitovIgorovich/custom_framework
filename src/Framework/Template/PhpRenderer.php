<?php

namespace Framework\Template;


class PhpRenderer implements TemplateRenderer
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        $templateFile =  "$this->path/$view.php";

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }
}