<?php

namespace App\Action\Blog;

use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\JsonResponse;

class ShowAction
{
	public function __invoke(Request $request, callable $next)
	{
		$id = $request->getAttribute('id');

		if ($id > 2){
			return $next($request);
		}

		return new JsonResponse(['id'=> $id, 'title' => "Post id: $id"]);
	}
}