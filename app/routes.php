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

Route::get('/', 'HomeController@showWelcome');

Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{

    Route::get('validate/{entity}', 'DatasmartController@doValidate');

    Route::post('lookup/{entity}', 'DatasmartController@doLookup');

    // Route::post('lookup/{entity}', 'DatasmartController@doValidate');

});