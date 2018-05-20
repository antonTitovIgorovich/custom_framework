<?php

namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewarePipe;

class Application extends MiddlewarePipe
{
	private $resolver;
	private $router;
	private $default;
	private $basePath = null;

	public function __construct(MiddlewareResolver $resolver, Router $router, callable $default, ResponseInterface $response)
	{
		parent::__construct();
		$this->resolver = $resolver;
		$this->router = $router;
		$this->setResponsePrototype($response);
		$this->default = $default;
	}

	public function pipe($path, $middleware = null): MiddlewarePipe
	{
	    if ($middleware === null){
            return parent::pipe($this->resolver->resolve($path, $this->responsePrototype));
        }
        return parent::pipe($this->toWrapPath($path), $this->resolver->resolve($middleware, $this->responsePrototype));
	}

	public function run(ServerRequestInterface $request, ResponseInterface $response)
	{
		return $this($request, $response, $this->default);
	}

    public function route($name, $path, $handler, array $methods, array $options = [])
    {
        $this->router->addRoute(new RouteData($name,  $this->toWrapPath($path), $handler, $methods, $options));
    }

    public function get($name, $path, $handler, array $options = [])
    {
        $this->route($name,  $path, $handler, ['GET'], $options);
    }

    public function post($name, $path, $handler, array $options = [])
    {
        $this->route($name,  $path, $handler, ['POST'], $options);
    }

    public function any($name, $path, $handler, array $options = [])
    {
        $this->route($name,  $path, $handler, [], $options);
    }

    /**
     * @param string $basePath
     */
    public function withBasePath($basePath = null)
    {
        is_string($basePath) && $this->basePath = $basePath;
    }

    /**
     * @param string $path
     * @return string
     */
    private function toWrapPath($path)
    {
        return !is_null($this->basePath) ? $this->basePath . $path : $path;
    }
}