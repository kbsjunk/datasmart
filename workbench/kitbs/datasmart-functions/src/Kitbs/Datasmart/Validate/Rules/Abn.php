<?php namespace Kitbs\Datasmart\Validate\Rules;

use Respect\Validation\Rules\AbstractRule;

class Abn extends AbstractRule
{

	public function unformat($input)
	{
		return preg_replace('/[^\d]*/', '', $input);
	}

	public function format($input)
	{
		$input = $this->unformat($input);
		return preg_replace('/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{3})/', '$1 $2 $3 $4', $input);
	}

	public function validate($input)
	{

		$input = $this->unformat($input);
		$inputLen = strlen($input);

		if (is_numeric($input) && $inputLen == 11) {

			$sum = 0;

			// Multiply each of the digits by its weighting factor, summing the products		
			for ($position=0; $position < $inputLen; $position++) {

				// Get the value of the current digit
				$current = intval($input[$position]);

				switch ($position+1) {
					case 1:
					$sum = $sum + (10 * ($current - 1));
					break;
					case 2:
					$sum = $sum + (1 * $current);
					break;
					case 3:
					$sum = $sum + (3 * $current);
					break;
					case 4:
					$sum = $sum + (5 * $current);
					break;
					case 5:
					$sum = $sum + (7 * $current);
					break;
					case 6:
					$sum = $sum + (9 * $current);
					break;
					case 7:
					$sum = $sum + (11 * $current);
					break;
					case 8:
					$sum = $sum + (13 * $current);
					break;
					case 9:
					$sum = $sum + (15 * $current);
					break;
					case 10:
					$sum = $sum + (17 * $current);
					break;
					case 11:
					$sum = $sum + (19 * $current);
					break;
				}

			}
			//If total is exactly divisble by 89 then it is an ABN
			return ($sum % 89 == 0);
		}

		return false;
	}

}