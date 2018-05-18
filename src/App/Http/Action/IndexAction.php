<?php

namespace App\Http\Action;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction
{
    private $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    function __invoke(Request $request) {
		$name = $request->getQueryParams()['name'] ?? 'Guest';
		return new HtmlResponse($this->template->render('app/hello', compact('name')));
	}

}