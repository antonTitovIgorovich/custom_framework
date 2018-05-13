<?php

namespace Framework\Container;

class ServiceNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $id)
    {
        parent::__construct('Undefined service "' . $id . '"');
    }
}