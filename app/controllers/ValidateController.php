<?php

class ValidateController extends BaseController {

	public function doValidate($against, $input = false, $second = false, $third = false, $fourth = false)
	{

		$response = array(
			'against'   => $against,
			'input'     => $input,
			'arguments' => array_filter(array($second, $third, $fourth))
			);

		$cacheKey = 'validate::'.md5(serialize($response));

		//Cache::forget($cacheKey);

		if (Cache::has($cacheKey)) {
			return $this->doResponse(Cache::get($cacheKey), true, true);
		}

		switch ($against) {
			case 'abn':
			$valid = Validate::abn()->validate($input);
			break;
			default:
			return $this->doResponse($response, false);
		}

		

		$response['valid'] = $valid ? 1 : 0;


		// } catch(\InvalidArgumentException $e) {
		// 	$response['valid'] = 0;
		// 	$response['error'] = $e->getFullMessage();
		// }

		Cache::put($cacheKey, array(Carbon::now()->toDateTimeString(), $response), 10);

		return $this->doResponse($response);

	}

	private function doResponse($response, $success = true, $cached = false) {

		$status = $success ? 'success' : 'fail';
		$payload = array('status' => $status, 'data' => $response);
		if ($cached) {
			$payload['cached'] = 1;
			$payload['cachedSince'] = $payload['data'][0];
			$payload['data'] = $payload['data'][1];
		}

		return Response::json($payload);
	}

}