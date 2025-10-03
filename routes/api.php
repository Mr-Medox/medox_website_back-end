<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->group(function () {
    // Blog routes
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/featured', [BlogController::class, 'featured']);
    Route::get('/blogs/categories', [BlogController::class, 'categories']);
    Route::get('/blogs/{slug}', [BlogController::class, 'show']);
    
    // Portfolio routes
    Route::get('/portfolios', [PortfolioController::class, 'index']);
    Route::get('/portfolios/featured', [PortfolioController::class, 'featured']);
    Route::get('/portfolios/categories', [PortfolioController::class, 'categories']);
    Route::get('/portfolios/industries', [PortfolioController::class, 'industries']);
    Route::get('/portfolios/{slug}', [PortfolioController::class, 'show']);
    
    // Contact routes
    Route::post('/contact', [ContactController::class, 'store']);
    
    // Testimonial routes
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/testimonials/featured', [TestimonialController::class, 'featured']);
});

// Admin API routes
Route::prefix('v1/admin')->group(function () {
    // Authentication routes
    Route::post('/login', [AdminController::class, 'login']);
    
    // Protected admin routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::get('/profile', [AdminController::class, 'profile']);
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        
        // Contact management
        Route::get('/contacts', [ContactController::class, 'index']);
        Route::get('/contacts/stats', [ContactController::class, 'stats']);
        Route::get('/contacts/{contact}', [ContactController::class, 'show']);
        Route::put('/contacts/{contact}', [ContactController::class, 'update']);
        
        // Blog management
        Route::apiResource('blogs', BlogController::class);
        
        // Portfolio management
        Route::apiResource('portfolios', PortfolioController::class);
        
        // Testimonial management
        Route::apiResource('testimonials', TestimonialController::class);
    });
});

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});
