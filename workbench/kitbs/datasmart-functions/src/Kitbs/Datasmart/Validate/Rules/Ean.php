<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;

class Ean extends AbstractCodevro
{

	function validate($input) {

		$input = $this->unformat($input);

		if (strlen($input) == 13) {
			$this->init('Intl\\Ean13', $input, true);
		}
		elseif (strlen($input) == 10) {
			$this->init('Intl\\Ean', $input, true);
		}
		elseif (strlen($input) == 8) {
			$this->init('Intl\\Ean8', $input, true);
		}
		else {
			return false;
		}

		return $this->process();

	}

}