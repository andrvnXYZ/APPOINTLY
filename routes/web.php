<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MicrosoftAuthController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Login Page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Google Auth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::post('/logout/google', [AuthController::class, 'logout'])->name('google.logout');

// Microsoft Auth Routes
Route::get('/auth/microsoft', [MicrosoftAuthController::class, 'redirect'])->name('microsoft.login');
Route::get('/auth/microsoft/callback', [MicrosoftAuthController::class, 'callback'])->name('microsoft.callback');
Route::get('/logout', [MicrosoftAuthController::class, 'logout'])->name('logout');