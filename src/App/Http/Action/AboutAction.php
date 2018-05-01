<?php

namespace App\Action;

use Zend\Diactoros\Response\HtmlResponse;

class AboutAction
{
	public function __invoke(){
		return new HtmlResponse('I am simple suite');
	}
}