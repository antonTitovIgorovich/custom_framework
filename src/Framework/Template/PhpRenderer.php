<?php

namespace Framework\Template;


use Framework\Http\Router\Router;
use function PHPSTORM_META\type;

class PhpRenderer implements TemplateRenderer
{
    private $path;
    private $extend;
    private $blocks = [];
    private $blockNames;
    /** @var Router $router */
    private $router;


    public function __construct($path, Router $router)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
        $this->router = $router;
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

        return $this->render($this->extend);
    }

    public function extend($view)
    {
        $this->extend = $view;
    }

    public function block($name, $content)
    {
        if ($this->hasBlock($name)){
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function beginBlock($name)
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock()
    {
        $content = ob_get_clean();
        $name = $this->blockNames->pop();
        if ($this->hasBlock($name)){
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock($name)
    {
        $block = $this->blocks[$name] ?? null;
        if ($block instanceof \Closure){
            return $block();
        }
        return $block ?? '';
    }

    public function hasBlock($name)
    {
        return array_key_exists($name, $this->blocks);
    }

    public function ensureBlock($name)
    {
        if (!$this->hasBlock($name)){
            return false;
        }
        $this->beginBlock('name');
        return true;
    }

    public function encode($val)
    {
        return htmlspecialchars($val, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function path($name, array $param = [], bool $encode = true): string
    {
        $path = $this->router->generate($name, $param);

        if ($encode){
            return $this->encode($path);
        }
        return $path;
    }
}