<?php

class V1DatasmartController extends BaseController {

	/**
	 * Validate the entity.
	 *
	 * @return Response
	 */
	public function doFunction($function, $entity, $format)
	{
		$input = '64162154752';

		$response = array(
			'input' => $input,
			'entity' => $entity,
			'function' => $function,
			);

		try {
			$class = Datasmart::factory($entity, $input);

			try {
				$result = $class->call($function);
				$response['result'] = $result;
				return Response::jsend($response, true, array('format' => $format));
			}
			catch (Exception $e) {
				return Response::jsend($response, true, array('errorMessage' => $e->getMessage(), 'format' => $format));
			}
		}
		catch (Exception $e) {
			return Response::jsend($response, true, array('errorMessage' => $e->getMessage(), 'format' => $format));
		}
	}

}
