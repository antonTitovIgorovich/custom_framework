<?php

namespace Framework\Http\Router\Route;

use Psr\Http\Message\ServerRequestInterface;

interface Route
{
	public function match(ServerRequestInterface $request);
	public function generate($name, array $params = []);
}