<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', 'HomeController@showWelcome');

Route::get('/testapi', 'TestController@index');

Route::group(array('prefix' => 'api/v1', 'before' => array('auth.basic', 'checkFormat', 'checkEntity')), function()
{

	Route::post('{function}/{entity}.{format}', 'V1DatasmartController@doFunction');

	// Route::get('{function}/{entity}.{format}', function() {
	// 	return Response::make(View::make('errors.badget'), 400);
	// });

});

App::missing(function()
{
	$format = substr(strrchr(Request::path(), "."), 1);
	if ($format) {
		return Response::jsend(false, false, array('errorMessage' => "404 Not Found", 'format' => $format));
	}
	else {
		return View::make('errors.notfound');
	}

});