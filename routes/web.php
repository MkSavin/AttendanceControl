<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'Get'])->name('login');
Route::post('/login', [LoginController::class, 'Post']);
Route::get('/logout', [LoginController::class, 'Logout'])->name('login.logout');

Route::group(['middleware' => 'login'], function () {
    Route::get('/', [IndexController::class, 'Get'])->name('index');
    Route::get('/redeem', [IndexController::class, 'Redeem'])->name('redeem');
});
