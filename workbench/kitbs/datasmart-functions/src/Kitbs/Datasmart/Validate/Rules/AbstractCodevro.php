<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;
use Exception;

class AbstractCodevro extends AbstractRule
{

	protected $class;

	public function unformat($input) {
		return preg_replace('/[^\d]*/', '', $input);
	}

	protected function init($className, $input, $unformat = false)
	{
		if ($unformat) $input = $this->unformat($input);

		$className = 'Malenki\\Codevro\\'.$className;
		$this->class = new $className($input);
	}

	public function validate($input) { 	}

	public function process() {

		// try {
			return $this->class->check();
		// }
		// catch (Exception $e) {
			// print_r($e->getMessage());
		// }

	}

}