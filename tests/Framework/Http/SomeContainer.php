<?php

namespace Test\Framework\Http;

use Framework\Container\Container;
use Framework\Container\ServiceNotFoundException;

class SomeContainer extends Container
{
    public function get($id)
    {
        if (!class_exists($id)){
            throw new ServiceNotFoundException($id);
        }
        return new $id();
    }

    public function set($id, $value){}

    public function has($id): bool
    {
        return class_exists($id);
    }
}