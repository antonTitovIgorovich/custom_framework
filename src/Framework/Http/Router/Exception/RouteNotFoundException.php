<?php

namespace Framework\Http\Router\Exception;

class RouteNotFoundException extends \LogicException
{
	private $name;
	private $param;

	public function __construct($name, array $param)
	{
		parent::__construct('Route "' . $name . '" not found!');
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
