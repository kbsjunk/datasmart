<?php namespace Kitbs\Datasmart\Barcode;

use Zend\Barcode\Barcode as Zend;
use Illuminate\Support\Facades\Config;

class Barcode extends Zend {

	public static function create($format, $input, $mime) {

		$imageTypes = array(
			'png'  => 'image',
			'jpg'  => 'image',
			'jpeg' => 'image',
			'gif'  => 'image',
			'svg'  => 'svg',
			);

		if (!$rendererType = array_get($imageTypes, $mime)) {
			\App::abort(404);
		}

		$barcodeOptions = array('text' => $input);
		$rendererOptions = array('imageType' => $mime);

		static::factory($format, $rendererType, $barcodeOptions, $rendererOptions)->render();die;
	}

	public static function allowed($barcode)
	{
		$allowed = Config::get("datasmart::namespaces.barcode");

		return in_array($barcode, $allowed);

	}
}