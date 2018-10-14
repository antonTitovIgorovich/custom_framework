<?php


namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ErrorResponseGenerator
{
    public function generate(ServerRequestInterface $request, \Throwable $e): ResponseInterface;
}