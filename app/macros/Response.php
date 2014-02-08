<?php

Response::macro('xml', function($value)
{
	$contents = array_to_xml($value);
	$response = Response::make($contents, 200);
	$response->header('Content-Type', 'application/xml');

	return $response;
});

/**
 * Transform PHP array to a XML document
 *
 * https://github.com/laravel/laravel/blob/e7559b366649445f6da745fbfdaa8d57687c913b/laravel/helpers.php
 * @param array $array The PHP array to transform
 * @return string The xml
 */
function array_to_xml($array, $xml = false){

	if ($xml === false)
	{
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response />');
	}

	foreach($array as $key => $value)
	{
		if (is_array($value))
		{
			array_to_xml($value, $xml->addChild($key));
		}
		else
		{
			$xml->addChild($key, $value);
		}
	}

	return $xml->asXML();
}