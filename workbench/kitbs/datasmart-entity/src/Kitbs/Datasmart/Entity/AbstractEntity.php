<?php namespace Kitbs\Datasmart\Entity;

use Respect\Validation\Validator as Validate;

abstract class AbstractEntity {

	private $value;
	private $params;
	private $errors;

	public $allowedFormat = '0';

	public function call($function, $params = array()) {
		if (method_exists($this, $function)) {
			return call_user_func_array(array(&$this, $function), $params);
		}

		throw new \Exception;
	}

	public function validatesBy()
	{
		return Validate::string()->length(1, null)->callback(array($this, 'customValidate'));;
	}

	public function customValidate() { return true; }

	public function validate()
	{
		return $this->validatesBy()->validate($this->value);
	}

	public function lookup() { return array(); }

	// public function validateWhy()
	// {
	// 	try {
	// 		return $this->validatesBy()->assert($this->value);
	// 	}
	// 	catch (\InvalidArgumentException $e) {
	// 		$this->errors = $e->getFullMessage();
	// 		dd($this->errors);
	// 		return false;
	// 	}
	// }

	public function format()
	{
		if ($this->validate()) {
			$value = $this->unformat();
			if (list($find, $replace) = $this->getFormat()) {
				return preg_replace('/^'.$find.'$/', $replace, $value);
			}
		}
		return $this->value;
	}

	public function unformat()
	{
		$allowedCharacters = $this->getAllowedCharacters();
		return trim(preg_replace('/[^'.$allowedCharacters.']/m', '', $this->value));
	}

	/* ----------------------------------------------------------- */

	public function __construct($value = false)
	{
		$this->setValue($value);
	}

	public function setValue($value) { $this->value = $value; }

	public function getValue() { return $this->value; }

	public function getFormat()
	{
		$allowedFormat = str_replace('\\', '\\\\', $this->allowedFormat);

		preg_match_all('/(?:(0+)|(A+)|([^0A]+))/', $allowedFormat, $find, PREG_PATTERN_ORDER);
		
		$find     = $find[0];
		$group    = 0;
		$replace  = array();
		
		for ($i = 0; $i < count($find); $i++) {
			$item = $find[$i];
			$preg = $this->substituteCharacter($item);

			if ($preg) {
				$group++;
				$replace[] = '$'.$group;
				$find[$i] = str_replace($item, '(['.$preg.']{'.strlen($item).'})', $item);
			}
			else {
				$find[$i] = false;
				$replace[] = $item;
			}
		}

		$find = implode('', $find);
		$replace = implode('', $replace);
		
		return array($find, $replace);
	}

	public function getAllowedCharacters()
	{
		$allowedCharacters = array();

		if (stristr($this->allowedFormat, 'A'))
			$allowedCharacters[] = $this->substituteCharacter('A');
		if (stristr($this->allowedFormat, '0'))
			$allowedCharacters[] = $this->substituteCharacter('0');
		
		return implode('', $allowedCharacters);
	}

	public function getAllowedCharactersUnformatted() {

	}

	private function substituteCharacter($character) {
		$characters = array('A' => 'A-Z', '0' => '0-9');
		return array_get($characters, substr($character, 0, 1));
	}

}