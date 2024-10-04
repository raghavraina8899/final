<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\PasswordController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/phpinfo', function () {
    return view('phpinfo');
});

Route::group(['middleware' => 'setlocale'], function () {
    // Routes that should have SetLocale middleware applied
    Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');



Route::get('/reset-password', [PasswordController::class, 'showResetPasswordForm'])
->middleware('check.reset.token');

Route::view('/404', 'errors.404')->name('404page');

Route::get('/invalid-link', function () {
return view('errors.custom404');
})->name('404.page');


Route::group(['middleware' => 'prevent-url-change'], function () {

Route::get('/', function () {
   return view('home');
})->name('/');

// Public Routes

Route::get('register', function () {
return view('register');
})->name('register');

Route::get('login', function () {
return view('/login');
})->name('login');

Route::get('dashboard', function () {
return view('/admin.dashboard');
})->name('admin.dashboard');

Route::get('user_dashboard', function () {
return view('/user.dashboard');
})->name('user.dashboard');

Route::get('profile_update', function () {
return view('/admin.profile_update');
})->name('admin.profile_update');

Route::get('forgotPassword', function () {
return view('forgot');
})->name('forgotPassword');


// Auth Routes
Route::middleware('auth:api')->get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/first', function () {
return view('first');
})->name('first');

Route::get('/add_user', function(){
return view('admin.add_user');
})->name('admin.add_user');
Route::get('/view_user', function(){
return view('admin.view_user');
})->name('admin.view_user');
Route::get('admin/edit_user/{id}', function(){
return view('admin.edit_user');
})->name('admin.edit_user');
Route::get('/delete_user', function(){
return view('admin.delete_user');
})->name('admin.delete_user');


// Country
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


// State
Route::get('/add_state', function(){
return view('admin.state.add_state');
})->name('admin.add_state');
Route::get('/view_state', function(){
return view('admin.state.view_state');
})->name('admin.view_state');
Route::get('/edit_state', function(){
return view('admin.state.edit_state');
})->name('admin.edit_state');
Route::get('/delete_state', function(){
return view('admin.state.delete_state');
})->name('admin.delete_state');



// City
Route::get('/add_city', function(){
return view('admin.city.add_city');
})->name('admin.add_city');
Route::get('/view_city', function(){
return view('admin.city.view_city');
})->name('admin.view_city');
Route::get('/edit_city', function(){
return view('admin.city.edit_city');
})->name('admin.edit_city');
Route::get('/delete_city', function(){
return view('admin.city.delete_city');
})->name('admin.delete_city');


// Branch
Route::get('/add_branch', function(){
return view('admin.branch.add_branch');
})->name('admin.add_branch');
Route::get('/view_branch', function(){
return view('admin.branch.view_branch');
})->name('admin.view_branch');
Route::get('/edit_branch', function(){
return view('admin.branch.edit_branch');
})->name('admin.edit_branch');
Route::get('/delete_branch', function(){
return view('admin.branch.delete_branch');
})->name('admin.delete_branch');


// Tax
Route::get('/add_tax', function(){
return view('admin.tax.add_tax');
})->name('admin.add_tax');
Route::get('/view_tax', function(){
return view('admin.tax.view_tax');
})->name('admin.view_tax');
Route::get('/edit_tax', function(){
return view('admin.tax.edit_tax');
})->name('admin.edit_tax');
Route::get('/delete_tax', function(){
return view('admin.tax.delete_tax');
})->name('admin.delete_tax');



// Product
Route::get('/add_product', function(){
return view('admin.product.add_product');
})->name('admin.add_product');
Route::get('/view_product', function(){
return view('admin.product.view_product');
})->name('admin.view_product');
Route::get('/edit_product', function(){
return view('admin.product.edit_product');
})->name('admin.edit_product');
Route::get('/delete_product', function(){
return view('admin.product.delete_product');
})->name('admin.delete_product');

});





Route::get('user_profile', function () {
    return view('/user.user_profile');
    })->name('user.user_profile');





Route::get('events/view_product/{id}', function(){
    return view('events.view_product');
    })->name('events.view_product');

    Route::get('/my-bookings', [BookingController::class, 'showMyBookings']);


Route::get('/events', function(){
    return view('events/all_events');
})->name('events.all_events');



});




