<?php

namespace App\Action\Blog;

use Psr\Http\Message\ServerRequestInterface as Request ;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ShowAction
{
	public function __invoke(Request $request)
	{
			$id = $request->getAttribute('id');

			if ($id > 2){
				return new HtmlResponse('Undefined Page', 404);
			}

			return new JsonResponse(['id'=> $id, 'title' => "Post id: $id"]);
	}
}