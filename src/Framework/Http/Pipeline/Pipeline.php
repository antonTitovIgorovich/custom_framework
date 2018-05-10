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

	public function __invoke(ServerRequestInterface $request, ResponseInterface $responsePrototype, callable $default): ResponseInterface
	{
        $delegate = new Next(clone $this->queue, $responsePrototype, $default);
        return $delegate($request);
	}

	public function pipe($middleware)
	{
		$this->queue->enqueue($middleware);
	}
}