<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register', 'register');
    Route::post('/register', 'store');
    Route::middleware('auth')->group(function(){    
        Route::get('/mypage/profile', 'profile');
        Route::patch('/mypage/profile/update', 'update');
    });
});

Route::get('/', function () {
    return view('index');
});