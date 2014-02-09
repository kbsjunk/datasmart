<?php

use Kitbs\Datasmart\Exception\WebserviceException;

class DatasmartController extends BaseController {

	/**
	 * Validate the entity.
	 *
	 * @return Response
	 */
	public function doFunction($function, $entity)
	{
		$input = '64162154752';

		$response = array(
			'input' => $input,
			'entity' => $entity,
			'function' => $function,
			);

		if ($class = Datasmart::instantiate($entity, $input)) {

			try {
				$result = $class->call($function);
				$response['result'] = $result;
				return Response::jsend($response);
			}
			catch (WebserviceException $e) {
				return Response::jsend($response, true, array('errorMessage' => "An error occurred while ."));
			}
			catch (Exception $e) {
				return Response::jsend($response, true, array('errorMessage' => "An error occurred while ."));
			}
		}

		return Response::jsend($response, true, array('errorMessage' => "Entity function '$function/$entity' not found."));
	}

}
