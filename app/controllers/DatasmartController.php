<?php

class DatasmartController extends BaseController {

	/**
	 * Validate the entity.
	 *
	 * @return Response
	 */
	public function doFunction($function, $entity)
	{
        if ($entity = Datasmart::getEntity($entity)) {
        	dd($entity->getFormat());
        }
	}

}
