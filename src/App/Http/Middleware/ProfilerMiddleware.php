<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProfilerMiddleware
{
	public function __invoke(ServerRequestInterface $request, callable $next)
	{
		$start = microtime(true);

		/** @var ResponseInterface $response */
		$response = $next($request);

		$stop = microtime(true);

		return $response->withHeader('X-Profiler', $stop - $start);
	}
}