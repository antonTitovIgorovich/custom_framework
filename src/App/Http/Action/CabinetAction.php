<?php

namespace App\Action;

use App\Middleware\BasicAuthMiddleware;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
	public function __invoke(ServerRequestInterface $request)
	{
		$user = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);
		return new HtmlResponse("Cabinet. User name is $user!");
	}
}