<?php

use App\Http\Controllers\cardsController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\userController;
use App\Http\Controllers\categoriesController;
use Illuminate\Http\Request; // Ensure this line is present and correctly imported
use Illuminate\Support\Facades\Route; // Import the Route facade

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

Route::post('/store/user', [userController::class, 'store']);
Route::put('/update/user', [userController::class, 'update']);
Route::delete('/delete/user', [userController::class, 'delete']);
Route::get('/index/user', [userController::class, 'index']);

Route::post('/store/card', [cardsController::class, 'store']);
Route::put('/update/card', [cardsController::class, 'update']);
Route::delete('/delete/card', [cardsController::class, 'delete']);
Route::get('/index/card', [cardsController::class, 'index']);

Route::post('/store/products', [ProductoController::class, 'store']);
Route::put('/update/products', [ProductoController::class, 'update']);
Route::delete('/delete/products', [ProductoController::class, 'delete']);
Route::get('/index/products', [ProductoController::class, 'index']);

Route::post('/store/categories', [categoriesController::class, 'store']);
Route::put('/update/categories', [categoriesController::class, 'update']);
Route::delete('/delete/categories', [categoriesController::class, 'delete']);
Route::get('/index/categories', [categoriesController::class, 'index']);
