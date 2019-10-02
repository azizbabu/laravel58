<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function() {
	Route::get('libraries', 'API\LibraryController@index');
	Route::group(['prefix' => 'library'], function() {
		Route::post('create', 'API\LibraryController@create');
		Route::get('edit/{id}', 'API\LibraryController@edit');
		Route::patch('update/{id}', 'API\LibraryController@update');
		Route::delete('delete/{id}', 'API\LibraryController@destroy');
	});
	Route::apiResource('companies', 'API\CompanyController');
	Route::apiResource('posts', 'API\PostController');
});

