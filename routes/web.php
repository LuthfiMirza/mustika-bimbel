<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Web Customer / Public Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::post('/daftar-trial', [LandingController::class, 'storeTrial'])->name('landing.store-trial');
Route::get('/cek-raport', [LandingController::class, 'checkReport'])->name('landing.check-report');
