<?php

namespace App\Action;

use Aura\Router\Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction
{
	function __invoke(Request $request) {

		$name = $request->getQueryParams()['name'] ?? 'Guest';

		return new HtmlResponse('Hello, ' . $name . '!');
	}

}