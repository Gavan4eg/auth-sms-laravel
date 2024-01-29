<?php

use App\Services\User\Controllers\UserLoginController;
use App\Services\User\Controllers\UserRegisterController;
use App\Services\User\Controllers\UserVerifyController;
use Illuminate\Support\Facades\Route;
use App\Services\User\Controllers\UserLogoutController;


Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('auth.register');
    Route::view('/login', 'auth.login')->name('auth.login');
    Route::view('/verify', 'auth.verify')
        ->middleware('user.check-session-code')
        ->name('auth.verify');
    Route::post('/register/create', UserRegisterController::class)->name('auth.register.create');
    Route::post('/login/user', UserLoginController::class)->name('auth.login.user');
    Route::post('/register/verify-code', UserVerifyController::class)->name('auth.verify.code');
});

Route::middleware('auth')->group(function () {
    Route::view('/', 'front.index')->name('front.index');
    Route::get('/auth/logout', UserLogoutController::class)->name('auth.logout');
});




