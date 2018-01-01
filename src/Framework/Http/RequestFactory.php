<?php

namespace Framework\Http;

class RequestFactory
{
	public static function fromGlobals(array $query = null, array $body = null)
	{
		return (new Request())
				->withQueryParams($query ?: $_GET)
					->withParsedBody($body ?: $_POST);
	}

}