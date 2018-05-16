<?php

namespace App\Action;

use App\Middleware\BasicAuthMiddleware;
use Framework\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    private $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

	public function __invoke(ServerRequestInterface $request)
	{
		$name = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);
		return new HtmlResponse($this->template->render('app/cabinet', compact('name')));
	}
}