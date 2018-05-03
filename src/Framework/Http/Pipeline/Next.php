<?php

namespace Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Next
{
	/**
	 * @var callable $default
	 */
	private $default;

	/**
	 * @var \SplQueue $queue
	 */
	private $queue;

	public function __construct(\SplQueue $queue, callable $default)
	{
		$this->queue= $queue;
		$this->default = $default;
	}

	public function __invoke(ServerRequestInterface $request)
	{
		if ($this->queue->isEmpty()) {
			return ($this->default)($request);
		}

		$current = $this->queue->dequeue();

		return $current($request, function (ServerRequestInterface $request){
			return $this($request);
		});
	}
}