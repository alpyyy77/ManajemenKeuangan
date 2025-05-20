<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PengeluaranController;
use App\Http\Controllers\API\UtangController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('transactions', TransactionController::class);
Route::apiResource('pemasukan', App\Http\Controllers\API\PemasukanController::class);
Route::apiResource('pengeluaran', App\Http\Controllers\API\PengeluaranController::class);
Route::apiResource('utang', App\Http\Controllers\UtangController::class);