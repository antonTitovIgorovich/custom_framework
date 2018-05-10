<?php

namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewarePipe;

class Application extends MiddlewarePipe
{
	private $resolver;
	private $default;
	private $basePath = null;

	public function __construct(MiddlewareResolver $resolver, callable $default, ResponseInterface $response)
	{
		parent::__construct();
		$this->resolver = $resolver;
		$this->setResponsePrototype($response);
		$this->default = $default;
	}

    /**
     * @param string $basePath
     */
	public function withBasePath($basePath = null)
    {
	    is_string($basePath) && $this->basePath = $basePath;
    }

	public function pipe($path, $middleware = null): MiddlewarePipe
	{
	    if ($middleware === null){
            return parent::pipe($this->resolver->resolve($path, $this->responsePrototype));
        }

        if (isset($this->basePath)) {
	        $path = $this->basePath . $path;
	    }

        return parent::pipe($path, $this->resolver->resolve($middleware, $this->responsePrototype));
	}

	public function run(ServerRequestInterface $request, ResponseInterface $response)
	{
		return $this($request, $response, $this->default);
	}
}