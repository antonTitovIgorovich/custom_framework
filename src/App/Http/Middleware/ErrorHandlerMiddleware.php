<?php

namespace App\Http\Middleware;

use Framework\Template\PhpRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorHandlerMiddleware
{
	private $debug;
	private $template;

	public function __construct(PhpRenderer $template,$debug = false)
	{
		$this->debug = $debug;
		$this->template = $template;
	}

	public function __invoke(ServerRequestInterface $request, callable $next)
	{
		try {
			return $next($request);
		} catch (\Throwable $e) {
		    $view = $this->debug ? 'error/error_debug' : 'error/error';

		    return new HtmlResponse($this->template->render($view, [
                'request' => $request,
                'exception' => $e
            ]), $e->getCode()?: 500);
		}
	}
}