<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;

class Ean13 extends AbstractCodevro
{

	function validate($input) {

		$this->init('Intl\\Ean13', $input, true);
		return $this->process();

	}

}