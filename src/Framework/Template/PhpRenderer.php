<?php

namespace Framework\Template;


class PhpRenderer implements TemplateRenderer
{
    private $path;
    private $extend;
    private $params = [];
    private $blocks = [];
    private $blockNames;


    public function __construct($path)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
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

        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend, compact('content'));
    }

    public function extend($view)
    {
        $this->extend = $view;
    }

    public function beginBlock($name)
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock()
    {
        $name = $this->blockNames->pop();
        $this->blocks[$name] = ob_get_clean();
    }

    public function renderBlock($name)
    {
        return $this->blocks[$name] ?? '';
    }
}