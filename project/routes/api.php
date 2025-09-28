<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Phiki\Phast\Root;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/products', [ProductController::class, 'showProducts']);

Route::middleware("auth:sanctum")->group(function(){
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::post('/cart/{id}', [CartController::class, 'addProduct']);
    Route::get('/cart', [CartController::class, 'showCart']);
    Route::delete('/cart/{id}', [CartController::class,'deleteProduct']);
    Route::patch('/profile', [CartController::class, 'editProfile']);
    
});




