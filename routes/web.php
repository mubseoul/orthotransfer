<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DoctorPracticeController;
use App\Http\Controllers\DoctorPatientController;

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
    
    // Ortho Detail routes (Patient only)
    Route::get('/dashboard/ortho-detail', [ProfileController::class, 'orthoDetail'])->name('dashboard.ortho-detail');
    Route::put('/dashboard/ortho-detail', [ProfileController::class, 'updateOrthoDetail'])->name('dashboard.ortho-detail.update');

    // Address routes (Patient only)
    Route::prefix('/dashboard/addresses')->name('dashboard.addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{id}', [AddressController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/set-current', [AddressController::class, 'setCurrent'])->name('set-current');
    });

    // Practice settings (Doctor only)
    Route::get('/dashboard/practice', [DoctorPracticeController::class, 'index'])->name('dashboard.practice');
    Route::put('/dashboard/practice', [DoctorPracticeController::class, 'update'])->name('dashboard.practice.update');

    // Practice address (Doctor only)
    Route::get('/dashboard/practice-address', [DoctorPracticeController::class, 'address'])->name('dashboard.practice.address');
    Route::put('/dashboard/practice-address', [DoctorPracticeController::class, 'updateAddress'])->name('dashboard.practice.address.update');

    // Doctor Patients
    Route::get('/dashboard/patients', [DoctorPatientController::class, 'index'])->name('dashboard.patients.index');
    Route::post('/dashboard/patients', [DoctorPatientController::class, 'store'])->name('dashboard.patients.store');
    Route::get('/dashboard/patients/{patientId}', [DoctorPatientController::class, 'show'])->name('dashboard.patients.show');
    Route::post('/dashboard/patients/{patientId}/upload', [DoctorPatientController::class, 'upload'])->name('dashboard.patients.upload');
    Route::get('/dashboard/patients/{patientId}/ortho', [DoctorPatientController::class, 'editOrtho'])->name('dashboard.patients.ortho.edit');
    Route::put('/dashboard/patients/{patientId}/ortho', [DoctorPatientController::class, 'updateOrtho'])->name('dashboard.patients.ortho.update');

    // Patient Doctors
    Route::get('/dashboard/my-doctors', [DoctorPatientController::class, 'myDoctors'])->name('dashboard.doctors.index');
    
    Route::get('/dashboard/my-doctors/{doctorId}', [DoctorPatientController::class, 'myDoctorDetail'])->name('dashboard.doctors.show');
    Route::post('/dashboard/my-doctors/{doctorId}/respond', [DoctorPatientController::class, 'respondToDoctor'])->name('dashboard.doctors.respond');
});



// Include admin routes
require __DIR__.'/admin.php';

