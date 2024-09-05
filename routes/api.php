<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CountryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Open Routes
Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::post('forgotPassword', [ApiController::class, 'forgotPassword']);


// Email Verification Routes
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.']);
})->middleware(['auth:api', 'signed'])->name('verification.verify');

Route::post('/email/resend-verification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:api'])->name('verification.send');

// Password Reset Routes
Route::post('/reset-password', [ApiController::class, 'resetPassword'])->name('api.reset-password');



// Protected Routes
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/dashboard', [ApiController::class, 'profile'])->name('admin.dashboard');
    Route::post('logout', [ApiController::class, 'logout']);
    Route::post('/profile_update', [ApiController::class, 'profile_update'])->name('admin.profile_update');
    Route::post('/password_update', [ApiController::class, 'password_update'])->name('admin.password_update');
    Route::post('first', [ApiController::class, 'first'])->name('api.first');
    Route::post('/add_user', [ApiController::class, 'addUser']);
    Route::get('/view_user', [ApiController::class, 'viewUser'])->name('api.view_user');
    Route::post('/edit_user', [ApiController::class, 'editUser'])->name('api.edit_user');
    Route::delete('/delete_user/{id}', [ApiController::class, 'deleteUser'])->name('api.delete_user');


    // Country
    Route::get('view-country-list', [CountryController::class, 'viewCountryList'])->name('api.view-country-list');
    Route::post('add-country', [CountryController::class, 'registerCountry']);
    Route::get('view-country/{id}', [CountryController::class, 'viewCountry']);
    Route::post('update-country/{id}', [CountryController::class, 'updateCountry']);
    Route::delete('delete-country/{id}', [CountryController::class, 'deleteCountry'])->name('api.delete-country');
});
