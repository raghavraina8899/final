<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
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
    Route::put('update', [ApiController::class, 'update'])->name('update');
    Route::post('first', [ApiController::class, 'first'])->name('api.first');

});
