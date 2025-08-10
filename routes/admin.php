<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminOptionsController;
use App\Models\User;
use App\Http\Controllers\AdminDoctorController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminPatientController;

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
        
        // Doctors management
        Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('admin.doctors.index');
        Route::get('/doctors/{user}', [AdminDoctorController::class, 'show'])->name('admin.doctors.show');
        Route::put('/doctors/{user}', [AdminDoctorController::class, 'update'])->name('admin.doctors.update');
        Route::put('/doctors/{user}/approve', [AdminDoctorController::class, 'approve'])->name('admin.doctors.approve');
        Route::put('/doctors/{user}/unapprove', [AdminDoctorController::class, 'unapprove'])->name('admin.doctors.unapprove');
        Route::post('/doctors/{user}/patients', [AdminDoctorController::class, 'attachPatient'])->name('admin.doctors.patients.attach');
        Route::delete('/doctors/{user}/patients/{patient}', [AdminDoctorController::class, 'detachPatient'])->name('admin.doctors.patients.detach');

        // Patients listing
        Route::get('/patients', [AdminPatientController::class, 'index'])->name('admin.patients.index');
        Route::get('/patients/{user}', [AdminPatientController::class, 'show'])->name('admin.patients.show');
        Route::put('/patients/{user}', [AdminPatientController::class, 'update'])->name('admin.patients.update');

        // Admin profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('/profile/verify-email', [AdminProfileController::class, 'verifyEmail'])->name('admin.profile.verify-email');
        Route::put('/profile/unverify-email', [AdminProfileController::class, 'unverifyEmail'])->name('admin.profile.unverify-email');

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