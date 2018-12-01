<?php


namespace App\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Stratigility\Utils;

class JsonErrorResponseGenerator implements ErrorResponseGenerator
{
    public function generate(ServerRequestInterface $request, \Throwable $e): ResponseInterface
    {
        return new JsonResponse(
            ['error' => $e->getMessage()],
            Utils::getStatusCode($e, new Response())
        );
    }
}
