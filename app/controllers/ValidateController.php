<?php

use Kitbs\Datasmart\Format\Format;

class ValidateController extends BaseController {

	public $cache;

	public function __construct() {
		$this->cache = Config::get('datasmart::cache');
	}

	public function doValidate($mime = '.json', $against, $input = false, $second = null, $third = null, $fourth = null)
	{

		$arguments = array_filter(array($second, $third, $fourth));

		$response = array(
			'against'   => $against,
			'input'     => $input,
			'arguments' => $arguments,
			);

		if ($this->cache) {
			$cacheKey = 'validate::'.md5(serialize($response));

			// Cache::forget($cacheKey);

			if (Cache::has($cacheKey)) {
				return $this->doResponse($mime, Cache::get($cacheKey), true, true);
			}
		}

		if (!Validate::allowed($against)) {
			$response['message'] = \Respect\Validation\Exceptions\ValidationException::format('Validation method "{{name}}" does not exist.', array('name'=>$against));
			return $this->doResponse($mime, $response, false);
		}

		$response['valid'] = (int) Validate::start($against, $arguments)->validate($input);

		if ($response['valid'] && $format = Format::start($against, $arguments)->format($input)) {
			$response['format'] = $format;
		}

		// } catch(\InvalidArgumentException $e) {
		// 	$response['valid'] = 0;
		// 	$response['error'] = $e->getFullMessage();
		// }

		if ($this->cache) {
			Cache::put($cacheKey, array(Carbon::now()->toDateTimeString(), $response), 10);
		}

		return $this->doResponse($mime, $response);

	}

	private function doResponse($mime, $response, $success = true, $cached = false) {

		$status = $success ? 'success' : 'fail';
		$payload = array('status' => $status, 'data' => $response);

		if ($cached) {
			// $payload['cached'] = 1;
			$dateTime = $payload['data'][0];

			if ($mime=='xml') { $dateTime = implode('T', explode(' ', $dateTime)); }
			$payload['cachedSince'] = $dateTime;
			$payload['data'] = $payload['data'][1];
		}

		switch ($mime) {
			case 'json':
			return Response::json($payload);
			break;

			case 'xml':
			return Response::xml($payload);
			break;

			case 'txt':
			if ($success) {
				return Response::make(Validate::tell($payload['data']['valid'], array('true', 'false')), 200);
			}
			else {
				return Response::make(null, 404);
			}
			break;

			// case 'csv':
			// if ($success) {
			// 	$response = array($status, $payload['data']['against'], $payload['data']['input'], Validate::tell($payload['data']['valid']));
			// 	return Response::make(implode(',', $response), 200);
			// }
			// else {
			// 	return Response::make(null, 404);
			// }
			// break;
			
			default:
			App::abort(404);
			break;
		}
		
	}

}