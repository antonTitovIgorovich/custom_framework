<?php

namespace Framework\Container;


use Throwable;

class ServiceNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}