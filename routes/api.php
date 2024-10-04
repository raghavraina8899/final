<?php

use App\Http\Controllers\Api\Admin\DashboardApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\PasswordController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Location\BranchController;
use App\Http\Controllers\Api\Location\CityController;
use App\Http\Controllers\Api\Location\CountryController;
use App\Http\Controllers\Api\Location\StateController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\TaxController;

// Open Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgotPassword', [PasswordController::class, 'forgotPassword']);

// Password Reset Routes
Route::get('/reset-password', [PasswordController::class, 'showResetPasswordForm']);

Route::get('/check-token-validity', [PasswordController::class, 'checkTokenValidity']);


Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('api.reset-password');

Route::get('view-product-list', [ProductController::class,'viewProductList'])->name('api.view-product-list');
Route::get('view-product/{id}', [ProductController::class, 'viewProduct'])->name('api.view-product');
Route::post('/book-product/{id}', [ProductController::class, 'bookProduct'])->name('book-product');

// Route::get('/my-bookings', [ProductController::class, 'viewBookings'])->name('bookings.index');

Route::get('/check-role', [UserController::class, 'checkRole'])->name('api.check-role');

Route::post('/book', [ProductController::class, 'book'])->name('event.book');

Route::get('/check-auth', [AuthController::class, 'checkAuth']);



Route::post('/book-product', [BookingController::class, 'bookProduct'])->name('book-product');

// Route::get('/my-bookings', [BookingController::class, 'myBookings']);
Route::get('/dashboard-stats', [DashboardApiController::class, 'getDashboardStats']);





// Protected Routes
Route::group(['middleware' => ['auth:api']], function () {


    Route::post('/book-product', [BookingController::class, 'bookProduct'])->name('book-product');

    Route::get('/my-bookings', [BookingController::class, 'myBookings']);

    Route::get('/dashboard', [ProfileController::class, 'profile'])->name('admin.dashboard');
    

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/profile_update', [ProfileController::class, 'profile_update'])->name('admin.profile_update');

    Route::post('/password_update', [PasswordController::class, 'password_update'])->name('admin.password_update');

    Route::post('first', [AuthController::class, 'first'])->name('api.first');

    Route::post('/add_user', [UserController::class, 'addUser'])->name('api.add_user');

    Route::get('/view_users', [UserController::class, 'viewUsers'])->name('api.view_users');

    Route::get('/view_user/{id}', [UserController::class, 'viewUserById'])->name('api.view_user');

    Route::post('/edit-user/{id}', [UserController::class, 'editUser'])->name('api.edit-user');

    Route::delete('/delete_user/{id}', [UserController::class, 'deleteUser'])->name('api.delete_user');

    Route::post('/remove_profile_picture', [ProfileController::class, 'removeProfilePicture']);


    // Country
    Route::get('view-country-list', [CountryController::class, 'viewCountryList'])->name('api.view-country-list');
    Route::post('add-country', [CountryController::class, 'registerCountry']);
    Route::get('view-country/{id}', [CountryController::class, 'viewCountry'])->name('api.view-country');
    Route::post('update-country/{id}', [CountryController::class, 'updateCountry'])->name('api.update-country');
    Route::delete('delete-country/{id}', [CountryController::class, 'deleteCountry'])->name('api.delete-country');


    // State
    Route::get('view-state-list', [StateController::class,'viewStateList'])->name('api.view-state-list');
    Route::post('add-state', [StateController::class, 'registerState']);
    Route::get('view-state/{id}', [StateController::class, 'viewState'])->name('api.view-state');
    Route::post('update-state/{id}', [StateController::class, 'updateState'])->name('api.update-state');
    Route::delete('delete-state/{id}', [StateController::class, 'deleteState'])->name('api.delete-state');


    // City
    Route::get('view-city-list', [CityController::class,'viewCityList'])->name('api.view-city-list');
    Route::post('add-city', [CityController::class, 'registerCity'])->name('api.add-city');
    Route::get('view-city/{id}', [CityController::class, 'viewCity'])->name('api.view-city');
    Route::post('update-city/{id}', [CityController::class, 'updateCity'])->name('api.update-city');
    Route::delete('delete-city/{id}', [CityController::class, 'deleteCity'])->name('api.delete-city');


    // Branch
    Route::get('view-branch-list', [BranchController::class,'viewBranchList'])->name('api.view-branch-list');
    Route::post('add-branch', [BranchController::class, 'registerBranch'])->name('api.add-branch');
    Route::get('view-branch/{id}', [BranchController::class, 'viewBranch'])->name('api.view-branch');
    Route::post('update-branch/{id}', [BranchController::class, 'updateBranch'])->name('api.update-branch');
    Route::delete('delete-branch/{id}', [BranchController::class, 'deleteBranch'])->name('api.delete-branch');


    Route::get('view-states-list/{countryId}', [StateController::class, 'getStatesByCountry']);
    Route::get('view-cities-list/{stateId}', [CityController::class, 'getCitiesByStates']);
    Route::get('view-branches-list/{cityId}', [BranchController::class, 'getBranchesByCities']);


    // Product
    
    Route::post('add-product', [ProductController::class, 'registerProduct'])->name('api.add-product');
    
    Route::post('update-product/{id}', [ProductController::class, 'updateProduct'])->name('api.update-product');
    Route::delete('delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('api.delete-product');


    Route::get('view-product-list/{taxId}', [ProductController::class, 'getproductsByTax']);



    // Tax
    Route::get('view-tax-list', [TaxController::class,'viewTaxList'])->name('api.view-tax-list');
    Route::post('add-tax', [TaxController::class, 'registerTax'])->name('api.add-tax');
    Route::get('view-tax/{id}', [TaxController::class, 'viewTax'])->name('api.view-tax');
    Route::post('update-tax/{id}', [TaxController::class, 'updateTax'])->name('api.update-tax');
    Route::delete('delete-tax/{id}', [TaxController::class, 'deleteTax'])->name('api.delete-tax');


});
