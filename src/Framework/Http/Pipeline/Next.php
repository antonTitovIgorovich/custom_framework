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

    /**
     * @var ResponseInterface
     */
	private $response;

	public function __construct(\SplQueue $queue, ResponseInterface $response, callable $default)
	{
		$this->queue= $queue;
		$this->default = $default;
		$this->response = $response;
	}

	public function __invoke(ServerRequestInterface $request)
	{
		if ($this->queue->isEmpty()) {
			return ($this->default)($request);
		}

		$current = $this->queue->dequeue();

		return $current($request, $this->response, function (ServerRequestInterface $request){
			return $this($request);
		});
	}
}