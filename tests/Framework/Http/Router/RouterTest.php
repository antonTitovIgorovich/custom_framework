<?php

namespace Tests\Framework\Http\Router;

use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
	private $routes;

	private $router;

	public function setUp()
	{
		$aura = new RouterContainer();
		$this->routes = $aura->getMap();
		$this->router = new AuraRouterAdapter($aura);
	}

	public function testCorrectMethod()
	{
		$this->routes->get($nameGet = 'blog', '/blog', $handlerGet = 'handler_get');
		$this->routes->post($namePost = 'blog_edit', '/blog', $handlerPost = 'handler_post');

		$result = $this->router->match($this->buildRequest('GET', '/blog'));
		self::assertEquals($nameGet, $result->getName());
		self::assertEquals($handlerGet, $result->getHandler());

		$result = $this->router->match($this->buildRequest('POST', '/blog'));
		self::assertEquals($namePost, $result->getName());
		self::assertEquals($handlerPost, $result->getHandler());
	}

	public function testMissingMethod()
	{
		$this->routes->post('blog', '/blog', 'handler_post');

		$this->expectException(RequestNotMatchedException::class);
		$this->router->match($this->buildRequest('DELETE', '/blog'));
	}

	public function testCorrectAttributes()
	{
		$this->routes->get($name = 'blog_show', '/blog/{id}', 'handler', ['id' => '\d+']);

		$result = $this->router->match($this->buildRequest('GET', '/blog/5'));

		self::assertEquals($name, $result->getName());
		self::assertEquals(['id' => '5'], $result->getAttributes());
	}

	public function testIncorrectAttributes()
	{
		$this->routes->get($name = 'blog_show', '/blog/{id}', 'handler', ['id' => '\d+']);

		$this->expectException(RequestNotMatchedException::class);
		$this->router->match($this->buildRequest('GET', '/blog_show/slug'));
	}

	public function testGenerate()
	{
		$this->routes->get('blog', '/blog', 'handler');
		$this->routes->get('blog_show', '/blog/{id}', 'handler', ['id' => '\d+']);

		self::assertEquals('/blog', $this->router->generate('blog'));
		self::assertEquals('/blog/5', $this->router->generate('blog_show', ['id' => 5]));
	}

	public function testGenerateMissingAttributes()
	{
		$this->routes->get('blog_show', '/blog/{id}', 'handler');

		$this->expectException(RouteNotFoundException::class);
		$this->router->generate('blog', ['slug' => 'post']);
	}

	private function buildRequest($method, $uri): ServerRequest
	{
		return (new ServerRequest())
			->withMethod($method)
			->withUri(new Uri($uri));
	}
}