<?php

/**
 * Output a JSend response in JSON (or XML)
 *
 * http://labs.omniti.com/labs/jsend
 *
 * @param array		$data		The PHP array to return as the "data" key
 * @param boolean	$success	Whether the request was made successfully or failed
 * @param array		$options	Various options including format, cached, errorMessage and errorCode
 *
 * @return Response
 *
 */

Response::macro('jsend', function($data, $success = true, $options = array())
{
	$defaultOptions = array(
		'format'       => 'json',
		'cached'       => false,
		'errorMessage' => false,
		'errorCode'    => false,
		);

	$options = array_merge($defaultOptions, $options);

	$payload = array();

	if ($options['errorMessage']) {
		$statusCode = 404;
		$payload['status'] = 'error';
		$payload['message'] = $options['errorMessage'];
		if ($options['errorCode']) $payload['code'] = $options['errorCode'];
	}
	else {
		$statusCode = $success ? 200 : 400;
		$payload['status'] = $success ? 'success' : 'fail';
	}

	if ($data) $payload['data'] = $data;

	// if ($options['cached']) {
	// 	$dateTime = $payload['data'][0];

	// 	if ($mime=='xml') { $dateTime = implode('T', explode(' ', $dateTime)); }
	// 	$payload['cachedSince'] = $dateTime;
	// 	$payload['data'] = $payload['data'][1];
	// }

	switch ($options['format']) {
		case 'json':
		return Response::json($payload, $statusCode);
		break;

		case 'xml':
		return Response::xml($payload, $statusCode);
		break;

		case 'txt':
		if ($payload['status'] == 'error') {
			return Response::make($payload['message'], $statusCode);
		}
		else {
			return Response::make(array_flatten(@$payload['data']), $statusCode);
		}
		break;

		default:
		return Response::make('Not Found', 404);
		break;
	}

});

/**
 * Create a XML response
 *
 * <code>
 *		// Create a response instance with XML
 *		return Response::xml($data, 200, array('header' => 'value'))
 * </code>
 *
 * @param	mixed	$data
 * @param	int	$status
 * @param	array	$headers
 * @return	Response
 */

Response::macro('xml', function($data, $status = 200, $headers = array())
{

	array_forget($headers, 'Content-Type');

	$contents = array_to_xml($data);
	$response = Response::make($contents, $status);
	$response->header('Content-Type', 'application/xml');
	if (is_array($headers)) {
		foreach ($headers as $key => $value) {
			$response->header($key, $value);
		}
	}

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