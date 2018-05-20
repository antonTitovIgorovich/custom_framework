<?php

namespace Framework\Http\Router\Exception;

class RouteNotFoundException extends \LogicException
{
	private $name;
	private $param;

	public function __construct($name, array $param, \Throwable $previous = null)
	{
		parent::__construct('Route "' . $name . '" not found!', 0, $previous);
		$this->name = $name;
		$this->param = $param;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getParam(): array
	{
		return $this->param;
	}

}
