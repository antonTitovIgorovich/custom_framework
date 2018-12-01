<?php

namespace Framework\Http\Router;

class RouteData
{
    public $name;
    public $path;
    public $handler;
    public $methods;
    public $options;

    public function __construct($name, $path, $handler, $methods, $options)
    {
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->options = $options;
    }
}
