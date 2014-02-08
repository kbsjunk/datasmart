<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;

class Isbn extends AbstractCodevro
{

	public function validate($input)
	{
		$input = $this->unformat($input);

		if (strlen($input) == 13) {
			$this->init('Intl\\Isbn', $input, true);
		}
		elseif (strlen($input) == 10) {
			$this->init('Intl\\Isbn10', $input, true);
		}
		else {
			return false;
		}
		
		return $this->process();
	}

	// public function format($input)
	// {
	// 	$this->init('Intl\\Isbn', $input);
	// 	$input = $this->class->getValue();


	// }

}