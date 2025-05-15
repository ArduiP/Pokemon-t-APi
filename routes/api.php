<?php

use App\Http\Controllers\AdressController;
use App\Http\Controllers\cardsController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\userController;
use App\Http\Controllers\categoriesController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TiketLineController;
use App\Http\Controllers\PagoController;
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
Route::post('/login/user', [userController::class,'login']);

Route::post('/store/card', [cardsController::class, 'store']);
Route::put('/update/card', [cardsController::class, 'update']);
Route::delete('/delete/card', [cardsController::class, 'delete']);
Route::get('/index/card', [cardsController::class, 'index']);
Route::get('/indexCardsByUserProduct/card', [cardsController::class, 'indexCardsByUserProduct']);

Route::post('/store/products', [ProductoController::class, 'store']);
Route::put('/update/products', [ProductoController::class, 'update']);
Route::delete('/delete/products', [ProductoController::class, 'delete']);
Route::get('/index/products', [ProductoController::class, 'index']);
Route::get('/onlyIdCardIndex/products', [ProductoController::class, 'onlyIdCardIndex']);

Route::post('/store/categories', [categoriesController::class, 'store']);
Route::put('/update/categories', [categoriesController::class, 'update']);
Route::delete('/delete/categories', [categoriesController::class, 'delete']);
Route::get('/index/categories', [categoriesController::class, 'index']);

Route::get('/index/adress', [AdressController::class, 'index']);
Route::post('/store/adress', [AdressController::class, 'store']);
Route::put('/update/adress', [AdressController::class, 'update']);
Route::delete('/delete/adress', [AdressController::class, 'delete']);

Route::get('/index/tikets',[TiketController::class, 'index']);
Route::post('/store/tikets',[TiketController::class, 'store']);
Route::put('/update/tikets',[TiketController::class, 'update']);
Route::delete('/delete/tikets',[TiketController::class, 'delete']);
Route::post('/tikets/create', [TiketController::class, 'create']);
Route::post('/update/ticket-quantity', [TiketController::class, 'updateQuantity']);


Route::get('/index/tiket_lineas',[TiketLineController::class, 'index']);
Route::post('/store/tiket_lineas',[TiketLineController::class, 'store']);
Route::put('/update/tiket_lineas',[TiketLineController::class, 'update']);
Route::delete('/delete/tiket_lineas',[TiketLineController::class, 'delete']);
Route::delete('/delete/tiket_lineas_chenping', [TiketLineController::class, 'deleteChenPing']);

Route::post('/store/pago', [PagoController::class, 'store']);
Route::put('/update/pago', [PagoController::class, 'update']);
Route::delete('/delete/pago', [PagoController::class, 'delete']);
Route::get('/index/pago', [PagoController::class, 'index']);
