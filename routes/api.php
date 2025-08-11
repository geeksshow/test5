<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [JWTAuthController::class, 'login'])->name('api.auth.login');
    Route::post('register', [JWTAuthController::class, 'register'])->name('api.auth.register');
    Route::post('refresh', [JWTAuthController::class, 'refresh'])->name('api.auth.refresh');
});

// Protected API routes
Route::group(['middleware' => 'auth:api'], function () {
    // Auth routes
    Route::group(['prefix' => 'auth'], function () {
        Route::get('me', [JWTAuthController::class, 'me'])->name('api.auth.me');
        Route::post('logout', [JWTAuthController::class, 'logout'])->name('api.auth.logout');
        Route::put('profile', [JWTAuthController::class, 'updateProfile'])->name('api.auth.update-profile');
        Route::put('password', [JWTAuthController::class, 'changePassword'])->name('api.auth.change-password');
    });
    
    // Other protected routes
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});

// Public API endpoints (no auth required)
Route::get('featured-products', [ApiController::class, 'getFeaturedProducts'])->name('api.featured-products');
Route::get('cart-count', [ApiController::class, 'getCartCount'])->name('api.cart-count');

// Test route
Route::get('test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});