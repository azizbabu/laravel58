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

Route::get('libraries', 'LibraryController@index');
Route::group(['prefix' => 'library'], function() {
	Route::post('create', 'LibraryController@create');
	Route::get('edit/{id}', 'LibraryController@edit');
	Route::patch('update/{id}', 'LibraryController@update');
	Route::delete('delete/{id}', 'LibraryController@destroy');
});
