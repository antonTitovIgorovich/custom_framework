<?php

namespace Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Pipeline
{
	private $queue;

	public function __construct()
	{
		$this->queue = new \SplQueue();
	}

	public function __invoke(ServerRequestInterface $request, callable $default): ResponseInterface
	{
		return $this->next($request, $default);
	}

	public function pipe($middleware)
	{
		$this->queue->enqueue($middleware);
	}

	private function next(ServerRequestInterface $request, callable $default)
	{
		$delegate = new Next(clone $this->queue, $default);
		return $delegate($request);
	}
}