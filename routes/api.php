<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Defines all CRUD routes for the 'products' resource using Laravel's API resource routing.
Route::apiResource('products', ProductController::class); 
Route::apiResource('categories', CategoryController::class); 

Route::get('/get_all_invoice', [InvoiceController::class, 'get_all_invoice']);

// Defines a POST route for user registration, handled by the 'register' method in the AuthController.
Route::post('/register', [AuthController::class, 'register']); 

// Defines a POST route for user login, handled by the 'login' method in the AuthController.
Route::post('/login', [AuthController::class, 'login']); 

// Defines a POST route for user logout, using Laravel Sanctum middleware for authentication, 
// handled by the 'logout' method in the AuthController.
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']); 