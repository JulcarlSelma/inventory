<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('product', ProductController::class)->except(['create', 'edit']);
Route::resource('category', CategoryController::class)->except(['create', 'edit', 'show']);
Route::resource('stock', StockController::class)->except(['create', 'edit']);
Route::resource('history', StockHistoryController::class)->except(['create', 'edit']);