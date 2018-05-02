<?php

namespace Test\App\Http\Action\Blog;

use App\Action\Blog\ShowAction;
use Zend\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class ShowActionTest extends TestCase
{
	public function testSuccess()
	{
		$action = new ShowAction();

		$request = (new ServerRequest())->withAttribute('id', $id = 2);

		$response = $action($request);

		self::assertEquals(200, $response->getStatusCode());
		self::assertJsonStringEqualsJsonString(
			json_encode(['id'=> $id, 'title' => "Post id: $id"]),
			$response->getBody()->getContents()
		);
	}

	public function testNotFound()
	{
		$action = new ShowAction();

		$request = (new ServerRequest())->withAttribute('id', 50);

		$response = $action($request);

		self::assertEquals(404, $response->getStatusCode());
		self::assertEquals('Undefined Page', $response->getBody()->getContents());
	}
}