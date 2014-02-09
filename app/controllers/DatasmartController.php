<?php

class DatasmartController extends BaseController {

	/**
	 * Validate the entity.
	 *
	 * @return Response
	 */
	public function doValidate($entity)
	{
        $entity = Datasmart::checkEntity($entity);
	}

}
