<?php

namespace Framework\Http\Pipeline;

use Interop\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewarePipe;

class MiddlewareResolver
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler, ResponseInterface $responsePrototype): callable
	{
		if (is_array($handler)) {
			return $this->createPipe($handler, $responsePrototype);
		}

		if (is_string($handler) && $this->container->has($handler)) {
			return function (ServerRequestInterface $request, ResponseInterface $response,  callable $next) use ($handler) {
				$middleware = $this->resolve($this->container->get($handler), $response);
				return $middleware($request, $response, $next);
			};
		}

		if ($handler instanceof MiddlewareInterface) {
		    return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
		        return $handler->process($request, new InteropHandlerWrapper($next));
            };
        }

        if (is_object($handler)) {
		    $reflection = new \ReflectionObject($handler);
		    if ($reflection->hasMethod('__invoke')) {
		        $method = $reflection->getMethod('__invoke');
		        $parameters = $method->getParameters();
		        if(count($parameters) === 2 && $parameters[1]->isCallable()){
                    return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler){
                      return $handler($request, $next);
                    };
                }
                return $handler;
            }
        }

		throw new UnknownMiddlewareException($handler);
	}

	private function createPipe(array $handlers, ResponseInterface $response): MiddlewarePipe
	{
		$pipeline = new MiddlewarePipe();
		$pipeline->setResponsePrototype($response);
		foreach ($handlers as $handler) {
			$pipeline->pipe($this->resolve($handler, $response));
		}
		return $pipeline;
	}
}