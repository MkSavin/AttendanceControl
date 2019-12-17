<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API роутинги
|--------------------------------------------------------------------------
|
| "api" middleware, RouteServiceProvider.
|
*/

Route::group(['namespace' => 'API'], function () {
    
    Route::get('/groups', 'GroupsController@Get');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/users', 'UsersController@Get');
        Route::get('/users/aside', 'UsersController@GetAside');
        Route::get('/users/aside/forsession', 'UsersController@GetAsideForSession');
        Route::get('/users/types', 'UsersController@GetTypes');
    
        Route::get('/user', 'UsersController@GetOne');
        Route::get('/user/check', 'UsersController@Check');

        Route::get('/user/password/generate', 'UsersController@GeneratePassword'); // TEMP
    
        Route::get('/group', 'GroupsController@GetOne');

        Route::get('/sessions/all', 'SessionsController@GetAll');

        Route::get('/session', 'SessionsController@GetOne');
        Route::get('/session/usecode', 'SessionsController@UseCode');
        Route::get('/session/create', 'SessionsController@Create');
        Route::get('/session/suitable', 'SessionsController@Suitable');
        
        Route::get('/attendance', 'AttendanceController@Get');
        Route::get('/attendance/add', 'AttendanceController@Add');

    });
});