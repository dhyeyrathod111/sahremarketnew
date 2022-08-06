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

Route::middleware(['checkApiAuthentication'])->group(function () {
   	Route::get('data', 'ApiController@index');
	// Route::post('getMemberToken', 'ApiController@getMemberToken')->name('getMemberToken');
});