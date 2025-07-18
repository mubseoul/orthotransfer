<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/demo', function () {
    return view('demo');
})->name('demo');

// Registration routes
Route::get('/register/patient', [RegisterController::class, 'showPatientForm'])->name('register.patient.form');
Route::post('/register/patient', [RegisterController::class, 'registerPatient'])->name('register.patient');

Route::get('/register/doctor', [RegisterController::class, 'showDoctorForm'])->name('register.doctor.form');
Route::post('/register/doctor', [RegisterController::class, 'registerDoctor'])->name('register.doctor');
