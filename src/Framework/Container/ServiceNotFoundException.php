<?php

namespace Framework\Container;

use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct('Undefined service "' . $id . '"');
    }
}