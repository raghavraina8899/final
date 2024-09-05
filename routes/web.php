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
Route::get('profile_update', function () {
    return view('/admin.profile_update');
})->name('admin.profile_update');
Route::get('forgotPassword', function () {
    return view('forgot');
})->name('forgotPassword');

// Auth Routes
Route::middleware('auth:api')->get('/logout', [ApiController::class, 'logout'])->name('logout');
// Route::middleware('auth')->get('/update', function () {
//     return view('update');
// })->name('update');
Route::get('/first', function () {
    return view('first');
})->name('first');

// Reset Password Route
Route::get('/reset-password', function (Request $request) {
    $email = $request->query('email');
    $otp = $request->query('otp');

    return view('reset_password', compact('email', 'otp'));
})->name('reset-password-form');



Route::get('/add_user', function(){
    return view('admin.add_user');
})->name('admin.add_user');
Route::get('/view_user', function(){
    return view('admin.view_user');
})->name('admin.view_user');
Route::get('/edit_user', function(){
    return view('admin.edit_user');
})->name('admin.edit_user');
Route::get('/delete_user', function(){
    return view('admin.delete_user');
})->name('admin.delete_user');


Route::get('/add_country', function(){
    return view('admin.country.add_country');
})->name('admin.add_country');
Route::get('/view_country', function(){
    return view('admin.country.view_country');
})->name('admin.view_country');
Route::get('/edit_country', function(){
    return view('admin.country.edit_country');
})->name('admin.edit_country');
Route::get('/delete_country', function(){
    return view('admin.country.delete_country');
})->name('admin.delete_country');

