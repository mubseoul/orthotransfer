<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/demo', function () {
    return view('demo');
})->name('demo');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register/patient', [RegisterController::class, 'showPatientForm'])->name('register.patient.form');
Route::post('/register/patient', [RegisterController::class, 'registerPatient'])->name('register.patient');

Route::get('/register/doctor', [RegisterController::class, 'showDoctorForm'])->name('register.doctor.form');
Route::post('/register/doctor', [RegisterController::class, 'registerDoctor'])->name('register.doctor');


// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    
    // Address routes
    Route::get('/dashboard/addresses', [AddressController::class, 'index'])->name('dashboard.addresses');
    Route::get('/dashboard/addresses/create', [AddressController::class, 'create'])->name('dashboard.addresses.create');
    Route::post('/dashboard/addresses', [AddressController::class, 'store'])->name('dashboard.addresses.store');
    Route::get('/dashboard/addresses/{address}/edit', [AddressController::class, 'edit'])->name('dashboard.addresses.edit');
    Route::put('/dashboard/addresses/{address}', [AddressController::class, 'update'])->name('dashboard.addresses.update');
    Route::patch('/dashboard/addresses/{address}/set-current', [AddressController::class, 'setCurrent'])->name('dashboard.addresses.set-current');
    Route::delete('/dashboard/addresses/{address}', [AddressController::class, 'destroy'])->name('dashboard.addresses.destroy');
});



// Include admin routes
require __DIR__.'/admin.php';

