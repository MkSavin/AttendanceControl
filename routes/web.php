<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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