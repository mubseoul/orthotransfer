<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminOptionsController;

// Admin authentication routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    
    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        // Options management routes
        Route::prefix('options')->name('admin.options.')->group(function () {
            Route::get('/{type}', [AdminOptionsController::class, 'index'])->name('index');
            Route::get('/{type}/create', [AdminOptionsController::class, 'create'])->name('create');
            Route::post('/{type}', [AdminOptionsController::class, 'store'])->name('store');
            Route::get('/{type}/{id}/edit', [AdminOptionsController::class, 'edit'])->name('edit');
            Route::put('/{type}/{id}', [AdminOptionsController::class, 'update'])->name('update');
            Route::delete('/{type}/{id}', [AdminOptionsController::class, 'destroy'])->name('destroy');
        });
    });
}); 