<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockHistoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('product', ProductController::class)->except(['create', 'edit']);
Route::apiResource('category', CategoryController::class)->except(['create', 'edit', 'show']);
Route::apiResource('stock', StockController::class)->except(['create', 'edit']);
Route::apiResource('history', StockHistoryController::class)->except(['create', 'edit']);