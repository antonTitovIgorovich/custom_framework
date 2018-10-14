<?php


namespace App\Http\Middleware\ErrorHandler;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


class AcceptErrorResponseGenerator implements ErrorResponseGenerator
{
    private $json;
    private $html;

    public function __construct(JsonErrorResponseGenerator $json, PrettyErrorResponseGenerator $html)
    {
        $this->json = $json;
        $this->html = $html;
    }

    public function generate(ServerRequestInterface $request, \Throwable $e): ResponseInterface
    {
        $accept = $request->getHeaderLine('Accept');

        $parts = explode(';', $accept);
        $mime = trim(array_shift($parts));

        if (preg_match('#[/+]json$#', $mime)){
            return $this->json->generate($request, $e);
        }

        return $this->html->generate($request, $e);
    }
}