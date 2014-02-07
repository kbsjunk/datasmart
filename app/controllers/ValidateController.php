<?php

class ValidateController extends BaseController {

	public function doValidate($against, $input = false, $second = false, $third = false, $fourth = false)
	{

		$response = array('against' => $against, 'arguments' = array_filter(array($input, $second, $third, $fourth)));

		try {
			$response['valid'] = Validate::tell(Validate::abn()->validate('49 781 030 034'));
		} catch(\InvalidArgumentException $e) {
			$response['valid'] = 'INVALID';
			$response['error'] = $e->getFullMessage();
		}

		return Response::json(array($reponse));

	}

}