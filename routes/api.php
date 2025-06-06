<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PengeluaranController;
use App\Http\Controllers\API\UtangController;
use App\Http\Controllers\API\PiutangController;


Route::middleware('auth:sanctum')->group(function () {
Route::apiResource('transactions', TransactionController::class);
});


Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('pemasukan', PemasukanController::class);
Route::apiResource('pengeluaran', PengeluaranController::class);
Route::apiResource('utang', UtangController::class);
Route::apiResource('piutang', PiutangController::class);


