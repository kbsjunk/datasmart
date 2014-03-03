<?php namespace Kitbs\Datasmart\Exception;

use Exception;

class EntityFunctionNotFoundException extends Exception
{
	public function __construct($entityFunction = false, $code = 0, Exception $previous = null) {
		parent::__construct("The entity function '$entityFunction' was not found.", $code, $previous);
	}

}