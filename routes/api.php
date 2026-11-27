<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API роутинги
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'App\Http\Controllers\API'], function () {
    
    Route::post('/user/check', 'UsersController@Check')->middleware('throttle:5,1');

    Route::group(['middleware' => ['bearer', 'auth:api']], function () {

        Route::get('/groups', 'GroupsController@Get');

        Route::get('/users', 'UsersController@Get');
        Route::get('/users/aside', 'UsersController@GetAside');
        Route::get('/users/aside/forsession', 'UsersController@GetAsideForSession');
        Route::get('/users/types', 'UsersController@GetTypes');
    
        Route::get('/user', 'UsersController@GetOne');

        Route::get('/group', 'GroupsController@GetOne');

        Route::get('/sessions/all', 'SessionsController@GetAll');

        Route::get('/session', 'SessionsController@GetOne');
        Route::post('/session/usecode', 'SessionsController@UseCode');
        Route::post('/session/create', 'SessionsController@Create');
        Route::get('/session/suitable', 'SessionsController@Suitable');
        
        Route::get('/attendance', 'AttendanceController@Get');
        Route::post('/attendance/add', 'AttendanceController@Add');

    });
});