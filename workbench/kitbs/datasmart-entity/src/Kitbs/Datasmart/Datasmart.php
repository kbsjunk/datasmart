<?php namespace Kitbs\Datasmart;

use Illuminate\Support\Facades\Config;
use Kitbs\Datasmart\Exception\EntityFunctionNotFoundException;

class Datasmart {

	private $config;

	public function __construct()
	{
		$this->config = Config::get('datasmart::config');
	}

	public function checkEntityFunction($entity, $function)
	{
		if (array_get($this->config, "entities.$entity.allowed.$function")) {
			return true;
		}

		throw new EntityFunctionNotFoundException("$function/$entity");
	}

	public function factory($entity, $value = false)
	{
		if ($class = array_get($this->config, "entities.$entity.class")) {
			$class = "Kitbs\\Datasmart\\Entity\\$class";
			return new $class($value);
		}
	}


	
}