<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeControllers;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\keyboardController;
use App\Http\Controllers\mouseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\JWTAuthController;






Route::get('/', [HomeControllers::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/laptops', [LaptopController::class, 'index'])->name('laptops.index');
Route::get('/keyboard', [keyboardController::class, 'index'])->name('keyboard.index');
Route::get('/mouse', [mouseController::class, 'index'])->name('mouse.index');

// Cart routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');

// API routes for AJAX calls
Route::get('/api/featured-products', [ApiController::class, 'getFeaturedProducts']);
Route::get('/api/cart-count', [ApiController::class, 'getCartCount']);

// JWT Auth routes (views and actions)
Route::get('/jwt/login', [JWTAuthController::class, 'showLoginForm'])->name('jwt.login');
Route::get('/jwt/register', [JWTAuthController::class, 'showRegisterForm'])->name('jwt.register');
Route::post('/jwt/login', [JWTAuthController::class, 'login'])->middleware('rate.limit:5,1');
Route::post('/jwt/register', [JWTAuthController::class, 'register'])->middleware('rate.limit:3,1');
Route::post('/jwt/logout', [JWTAuthController::class, 'logout'])->name('jwt.logout');

// Email verification routes
use App\Http\Controllers\Auth\EmailVerificationController;
Route::post('/email/send-otp', [EmailVerificationController::class, 'sendOTP'])->middleware('rate.limit:3,1')->name('email.send-otp');
Route::post('/email/verify-otp', [EmailVerificationController::class, 'verifyOTP'])->middleware('rate.limit:5,1')->name('email.verify-otp');
Route::get('/email/verification-status', [EmailVerificationController::class, 'checkVerificationStatus'])->name('email.verification-status');

// JWT API endpoints
Route::middleware(['auth:api'])->group(function () {
    Route::get('/jwt/me', [JWTAuthController::class, 'me'])->name('jwt.me');
    Route::post('/jwt/refresh', [JWTAuthController::class, 'refresh'])->name('jwt.refresh');
});

// Forgot Password Routes
Route::post('/api/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendOTP'])->middleware('rate.limit:3,1');
Route::post('/api/verify-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyOTP'])->middleware('rate.limit:5,1');
Route::post('/api/reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])->middleware('rate.limit:3,1');

// Social Authentication Routes
use App\Http\Controllers\Auth\SocialAuthController;
Route::post('/auth/google', [SocialAuthController::class, 'googleLogin'])->middleware('rate.limit:5,1');
Route::post('/auth/facebook', [SocialAuthController::class, 'facebookLogin'])->middleware('rate.limit:5,1');
Route::post('/auth/apple', [SocialAuthController::class, 'appleLogin'])->middleware('rate.limit:5,1');

// Test mail configuration (remove this in production)
Route::get('/test-mail', function() {
    try {
        Mail::raw('Test email from DND COMPUTERS', function($message) {
            $message->to('test@example.com')
                   ->subject('Test Email')
                   ->from(config('mail.from.address'), config('mail.from.name'));
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully!',
            'mail_config' => [
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name')
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test email: ' . $e->getMessage(),
            'mail_config' => [
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name')
            ]
        ]);
    }
});

// Modern Forgot Password Route
Route::get('/forgot-password', function() {
    return view('auth.forgot-password-modern');
})->name('forgot-password');

require __DIR__.'/auth.php';
