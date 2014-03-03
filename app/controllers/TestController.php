<?php

class TestController extends BaseController {

	/**
	 * Display the testing.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('testing');
	}


}
