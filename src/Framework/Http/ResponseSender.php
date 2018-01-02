<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;

class ResponseSender
{
	public function send(ResponseInterface $responce)
	{
		header(sprintf(
			'HTTP/%s %d %s',
			$responce->getProtocolVersion(),
			$responce->getStatusCode(),
			$responce->getReasonPhrase()
		));
		foreach($responce->getHeaders() as $name => $values){
			foreach($values as $value){
				header(sprintf('%s: %s', $name, $value), false);
			}
		}
		echo $responce->getBody()->getContents();
	}

}