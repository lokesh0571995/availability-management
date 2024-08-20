<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AvailabilityController;

Route::get('/', function () {
    return view('auth/login');
});



Route::middleware('auth')->group(function () {
    Route::get('/admin/availabilities', [AdminController::class, 'index'])->name('admin.availabilities');
    Route::get('/admin/availabilities/create', [AdminController::class, 'create']);
    Route::post('/admin/availabilities', [AdminController::class, 'store']);

    Route::get('/admin/categories', [CategoryController::class, 'index']);
    Route::get('/admin/categories/create', [CategoryController::class, 'create']);
    Route::post('/admin/categories', [CategoryController::class, 'store']);
});

Route::get('/availabilities', [AvailabilityController::class, 'index']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
