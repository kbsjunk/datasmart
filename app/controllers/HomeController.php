<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{

		$contents = array();

		try {
			$contents[] = Validate::tell(Validate::abn()->assert('49 781 030 034'));
		} catch(\InvalidArgumentException $e) {
			$contents[] = $e->getFullMessage();
		}

		try {
			$contents[] = Validate::tell(Validate::isbn()->assert('978-3-16-148410-0'));
		} catch(\InvalidArgumentException $e) {
			$contents[] = $e->getFullMessage();
		}

		try {
			$contents[] = Validate::tell(Validate::vat()->assert('DE 114 103 379'));
		} catch(\InvalidArgumentException $e) {
			$contents[] = $e->getFullMessage();
		}

		$response = Response::make(implode(PHP_EOL, $contents), 200);
		$response->header('Content-Type', 'text/plain');

		return $response;

	}

}