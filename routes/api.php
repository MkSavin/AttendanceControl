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

    Route::get('/group/', 'GroupsController@GetOne');

    Route::get('/users', 'UsersController@Get');
    Route::get('/users/aside', 'UsersController@GetAside');
    Route::get('/users/types', 'UsersController@GetTypes');

    Route::get('/user/', 'UsersController@GetOne');

    Route::get('/sessions/all', 'SessionsController@GetAll');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/session', 'SessionsController@GetOne');
        Route::get('/session/usecode', 'SessionsController@UseCode');
        Route::get('/session/create', 'SessionsController@Create');
        Route::get('/session/suitable', 'SessionsController@Suitable');
        
        Route::get('/attendance', 'AttendanceController@Get');
        Route::get('/attendance/add', 'AttendanceController@Add');

    });
});