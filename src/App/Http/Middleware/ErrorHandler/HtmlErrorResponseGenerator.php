<?php


namespace App\Http\Middleware\ErrorHandler;

use Framework\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HtmlErrorResponseGenerator implements ErrorResponseGenerator
{
    private $debug;
    private $template;

    public function __construct(bool $debug, TemplateRenderer $templateRenderer)
    {
        $this->debug = $debug;
        $this->template = $templateRenderer;
    }

    public function generate(ServerRequestInterface $request, $e): ResponseInterface
    {
        $view = $this->debug ? 'error/error-debug' : 'error/error';

        return new HtmlResponse($this->template->render($view, [
            'request' => $request,
            'exception' => $e,
        ]), self::getStatusCode($e));
    }

    protected static function getStatusCode(\Throwable $e)
    {
        $code = $e->getCode();
        if ($code >= 400 && $code < 600) {
            return $code;
        }
        return 500;
    }
}