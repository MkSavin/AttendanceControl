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

Route::group(['namespace' => 'API'], function () {
    
    Route::get('/groups', 'GroupsController@Get');
    Route::get('/users', 'UsersController@Get');
    Route::get('/users/aside', 'UsersController@GetAside');
    Route::get('/users/types', 'UsersController@GetTypes');

    Route::get('/sessions/all', 'SessionsController@GetAll');

});