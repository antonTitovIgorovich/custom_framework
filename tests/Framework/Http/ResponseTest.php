<?php

namespace Tests\Framework\Http;

use Framework\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
	public function testEmpty()
	{
		$response = new Response($body = 'Body');

		$this->assertEquals($body, $response->getBody());
		$this->assertEquals(200, $response->getStatusCode());
		$this->assertEquals('OK', $response->getReasonPhrase());
	}

	public function test404()
	{
		$response = new Response($body = 'Empty', $status = 404);

		$this->assertEquals($body, $response->getBody());
		$this->assertEquals($status, $response->getStatusCode());
		$this->assertEquals('Not Found', $response->getReasonPhrase());
	}

	public function testHeaders()
	{
		$response = (new Response('body'))
					->withHeader($name1 = 'Header1', $val1 = 'Value1')
						->withHeader($name2 = 'Header2', $val2 = 'Value2');
		
		$this->assertEquals([$name1 => $val1, $name2 => $val2], $response->getHeaders());
	}
}