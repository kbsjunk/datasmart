<?php

class ValidateController extends BaseController {

	public function validate($against, $input = false, $second = false, $third = false, $fourth = false)
	{

		$response = array(
			'against'   => $against,
			'input'     => $input,
			'arguments' => array_filter(array($second, $third, $fourth))
			);

		try {
			$response['valid'] = Validate::abn()->validate('49 781 030 034') ? 1 : 0;
		} catch(\InvalidArgumentException $e) {
			$response['valid'] = 0;
			$response['error'] = $e->getFullMessage();
		}

		return Response::json(array($response));

	}

}