<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register', 'register');
    Route::post('/register', 'store');
    Route::middleware('auth')->group(function(){    
        Route::get('/mypage/profile', 'profile');
        Route::patch('/mypage/profile/update', 'update');
    });
});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'showLogin');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::get('/', function () {
    return view('index');
});