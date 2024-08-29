<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Public Routes
Route::get('/', function () {
    return view('home');
});
Route::get('register', function () {
    return view('register');
})->name('register');
Route::get('login', function () {
    return view('login');
})->name('login');
Route::get('dashboard', function () {
    return view('/admin.dashboard');
})->name('admin.dashboard');
Route::get('profile', function () {
    return view('/admin.profile_update');
})->name('admin.profile_update');
Route::get('forgotPassword', function () {
    return view('forgot');
})->name('forgotPassword');

// Auth Routes
Route::middleware('auth:api')->get('/logout', [ApiController::class, 'logout'])->name('logout');
Route::middleware('auth')->get('/update', function () {
    return view('update');
})->name('update');
Route::get('/first', function () {
    return view('first');
})->name('first');

// Reset Password Route
Route::get('/reset-password', function (Request $request) {
    $email = $request->query('email');
    $otp = $request->query('otp');

    return view('reset_password', compact('email', 'otp'));
})->name('reset-password-form');

