<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('transactions', TransactionController::class);
Route::apiResource('pemasukan', App\Http\Controllers\API\PemasukanController::class);