<?php namespace Kitbs\Datasmart;

use Illuminate\Support\Facades\Config;

class Datasmart {

	private $config;

	public function __construct()
	{
		$this->config = Config::get('datasmart::config');
	}

	public function checkEntityFunction($entity, $function)
	{
		return (bool) array_get($this->config, "entities.$entity.allowed.$function");
	}

	public function getEntity($entity)
	{
		if ($class = array_get($this->config, "entities.$entity.class")) {
			$class = "Kitbs\\Datasmart\\Entity\\$class";
			return new $class;
		}
	}
	
}