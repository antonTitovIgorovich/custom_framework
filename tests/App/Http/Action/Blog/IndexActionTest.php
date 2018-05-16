<?php

namespace Test\App\Http\Action\Blog;

use App\Action\Blog\IndexAction;
use Test\App\Http\Action\BaseActionTestCase;

class IndexActionTest extends BaseActionTestCase
{
	public function testSuccess()
	{
		$action = new IndexAction();
		$response = $action();

		self::assertEquals(200, $response->getStatusCode());
		self::assertJsonStringEqualsJsonString(
			json_encode([
				['id' => 1, 'title' => 'The First Post'],
				['id' => 2, 'title' => 'The Second Post']
			]),
			$response->getBody()->getContents()
		);
	}
}