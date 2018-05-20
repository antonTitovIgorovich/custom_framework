<?php

namespace Test\Framework\Http;

use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class ApplicationTest extends TestCase
{
    private $resolver;
    private $router;

    public function setUp()
    {
        parent::setUp();
        $this->router = $this->createMock(Router::class);
        $this->resolver = new MiddlewareResolver(new DummyContainer());
    }

    public function testPipe()
	{
		$app = new Application($this->resolver, $this->router, new DefaultHandler(), new Response());

		$app->pipe(new Middleware1());
		$app->pipe(new Middleware2());

		$response = $app->run(new ServerRequest(), new Response());

		$this->assertJsonStringEqualsJsonString(
			json_encode(['middleware-1' => 1, 'middleware-2' => 2]),
			$response->getBody()->getContents()
		);
	}
}

class Middleware1
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		return $next($request->withAttribute('middleware-1', 1));
	}
}

class Middleware2
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		return $next($request->withAttribute('middleware-2', 2));
	}
}

class DefaultHandler
{
	public function __invoke(ServerRequestInterface $request)
	{
		return new JsonResponse($request->getAttributes());
	}
}