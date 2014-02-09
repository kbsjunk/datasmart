<?php namespace Kitbs\Datasmart\Exception;

class WebserviceException extends Exception
{
	public function __construct($message = false, $code = 0, Exception $previous = null) {
		parent::__construct('An error occurred with a web service: '. $message, $code, $previous);
	}

}