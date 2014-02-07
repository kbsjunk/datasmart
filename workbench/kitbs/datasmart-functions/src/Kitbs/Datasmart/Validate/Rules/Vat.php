<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;

class Vat extends AbstractCodevro
{

	function validate($input) {

		$this->init('Euro\\VatNumber', $input);
		return $this->process();

	}

}