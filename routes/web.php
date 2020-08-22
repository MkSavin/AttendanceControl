<?php

/*
|--------------------------------------------------------------------------
| Web роутинги
|--------------------------------------------------------------------------
|
| "web" middleware, RouteServiceProvider.
|
*/

Route::get('/login', [
    'uses' => 'LoginController@Get',
    'title' => 'Вход'
])->name('login');

Route::post('/login', [
    'uses' => 'LoginController@Post',
    'title' => 'Вход'
]);

Route::get('/logout', [
    'uses' => 'LoginController@Logout',
    'title' => 'Выход'
])->name('login.logout');

Route::group(['middleware' => 'login'], function () {

    Route::get('/', [
        'uses' => 'IndexController@Get',
        'title' => 'Главная'
    ])->name('index');

    Route::get('/redeem', [
        'uses' => 'IndexController@Redeem',
        'title' => 'Использование сеанса'
    ])->name('redeem');

});