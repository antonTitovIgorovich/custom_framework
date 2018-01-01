<?php

namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

	public function testEmpty()
	{
		$request = new Request();

		$this->assertEquals([], $request->getQueryParams());
		$this->assertNull($request->getParsedBody());
	}

	public function testGetQueryParams()
	{
		$request = (new Request())->withQueryParams(
			$data1 = [
			'name' => 'Lenon',
			'age' => 32
		]);

		$request1 = (new Request())->withQueryParams(
			$data2 = [
			'name' => 'Bond',
			'age' => 40
		]);

		$this->assertEquals($data1, $request->getQueryParams());
		$this->assertEquals($data2, $request1->getQueryParams());
		$this->assertNull($request->getParsedBody());	
	}

	public function testGetParsedBody()
	{
		$request = (new Request())->withParsedBody(
			$data = ['title' => 'title_string']
		);

		$this->assertEquals([], $request->getQueryParams());
		$this->assertEquals($data, $request->getParsedBody());	
	}
}