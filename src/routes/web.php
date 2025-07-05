<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;

Route::controller(RegisterController::class)->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store');
    });
    Route::middleware('auth')->group(function(){
        Route::get('/mypage/profile', 'profile');
        Route::patch('/mypage/profile/update', 'update');
    });
});

Route::controller(LoginController::class)->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
    });
    Route::middleware('auth')->group(function(){
        Route::post('/logout', 'logout')->name('logout');
    });
});

Route::controller(ItemController::class)->group(function(){
    Route::get('/','index');
    Route::middleware('auth')->group(function(){
        Route::get('/sell', 'sell');
        Route::post('/sell', 'store');
    });
    Route::get('/item/{item_id}', 'showItem');
});