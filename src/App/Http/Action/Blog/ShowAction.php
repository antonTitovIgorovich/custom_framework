<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ServerRequestInterface as Request;
use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Zend\Diactoros\Response\HtmlResponse;

class ShowAction
{
    private $posts;
    private $template;

    public function __construct(PostReadRepository $posts, TemplateRenderer $template)
    {
        $this->posts = $posts;
        $this->template = $template;
    }

	public function __invoke(Request $request, callable $next)
	{
        throw new \ErrorException('21');
	    if (!$post = $this->posts->find($request->getAttribute('id'))){
			return $next($request);
		}

		return new HtmlResponse($this->template->render('app/blog/show', compact('post')));
	}
}
