<?php namespace Kitbs\Datasmart\Barcode;

use Zend\Barcode\Barcode as Zend;
use Illuminate\Support\Facades\Config;

class Barcode extends Zend {

	public static function create($format, $input, $mime) {
		$barcodeOptions = array('text' => $input);
		$rendererOptions = array('imageType' => $mime);

		static::factory( $format, 'image', $barcodeOptions, $rendererOptions )->render();
	}

	public static function allowed($barcode)
	{
		$allowed = Config::get("datasmart::namespaces.barcode");

		return in_array($barcode, $allowed);

	}
}