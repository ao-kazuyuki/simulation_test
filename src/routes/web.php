<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BuyController;

Route::controller(RegisterController::class)->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'store');
    });
    Route::middleware('auth')->group(function(){
        Route::get('/mypage', 'mypage');
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

Route::controller(CommentController::class)->group(function(){
    Route::middleware('auth')->group(function(){
        Route::post('/item/{item_id}/comment', 'store');
    });
});

Route::controller(LikeController::class)->group(function(){
    Route::middleware('auth')->group(function(){
        Route::post('/item/{item_id}/like', 'store');
    });
});

Route::controller(BuyController::class)->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('/purchase/{item_id}', 'showBuyView');
        Route::patch('/purchase/{item_id}', 'showBuyViewChangedAddr');
        Route::post('/purchase/{item_id}', 'store');
        Route::post('/purchase/address/{item_id}', 'showChangeAddress');
        Route::get('/purchase/address/{item_id}', 'showChangeAddress');
    });
});