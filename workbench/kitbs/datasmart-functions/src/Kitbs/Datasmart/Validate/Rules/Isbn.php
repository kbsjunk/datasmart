<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;

class Isbn extends AbstractCodevro
{

	public function validate($input)
	{
		$this->init('Intl\\Isbn', $input, true);
		return $this->process();
	}

	// public function format($input)
	// {
	// 	$this->init('Intl\\Isbn', $input);
	// 	$input = $this->class->getValue();


	// }

}