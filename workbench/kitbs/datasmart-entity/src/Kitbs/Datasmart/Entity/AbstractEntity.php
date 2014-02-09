<?php namespace Kitbs\Datasmart\Entity;

class AbstractEntity {

	private $allowedChars = '';
	private $allowedFormat = '';

	public function validate() {

	}

	public function format() {

	}

	public function unformat() {

	}

	public function getFormat() {
		return str_replace(array('0','A'), array('[0-9]','[A-Z]'), $this->allowedFormat);
	}

}