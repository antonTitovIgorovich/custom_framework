<?php

namespace Test\App\Http\Action;

use App\Action\IndexAction;
use Zend\Diactoros\ServerRequest;

class IndexActionTest extends BaseActionTestCase
{
    public function testGuest()
	{
		$action = new IndexAction($this->renderer);

		$request = new ServerRequest();
		$response = $action($request);

		self::assertEquals(200, $response->getStatusCode());
		self::assertContains('Hello Guest!', $response->getBody()->getContents());
	}

	public function testJohn()
	{
		$action = new IndexAction($this->renderer);

		$request = (new ServerRequest())->withQueryParams(['name' => 'John']);
		$response = $action($request);

		self::assertContains('Hello John!', $response->getBody()->getContents());
	}
}