<?php

namespace Framework\Template;


use Framework\Http\Router\Router;
use Framework\Template\Php\Extension;

class PhpRenderer implements TemplateRenderer
{
    private $path;
    private $extend;
    private $blocks = [];
    private $blockNames;
    private $extensions = [];

    public function __construct($path)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
    }

    public function __call($name, $arguments)
    {
        foreach ($this->extensions as $extension) {
            $functions = $extension->getFunctions();
            foreach ($functions as $function) {
                if ($function->name === $name) {
                    if ($function->needRenderer) {
                        return ($function->callback)($this, ...$arguments);
                    }
                    return ($function->callback)(...$arguments);
                }
            }
        }
        throw new \InvalidArgumentException('Undefined function "' . $name . '"');
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws \Exception $e
     */
    public function render(string $view, array $params = []): string
    {
        $level = ob_get_level();
        try{
            $templateFile =  "$this->path/$view.php";
            ob_start();
            extract($params, EXTR_OVERWRITE);
            $this->extend = null;
            require $templateFile;
            $content = ob_get_clean();
            if (!$this->extend) {
                return $content;
            }
        }catch (\Exception $e){
            while(ob_get_level() > $level){
                ob_end_clean();
            }
            throw $e;
        }
        return $this->render($this->extend);
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

    public function addExtensions(Extension $extension)
    {
        $this->extensions[] = $extension;
    }

    public function extend($view)
    {
        $this->extend = $view;
    }

    public function encode($val)
    {
        return htmlspecialchars($val, ENT_QUOTES | ENT_SUBSTITUTE);
    }
}