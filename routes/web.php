<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ParentPortalController;
use Illuminate\Support\Facades\Route;

// Web Customer / Public Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::post('/daftar-trial', [LandingController::class, 'storeTrial'])->name('landing.store-trial');
Route::get('/cek-raport', [LandingController::class, 'checkReport'])->name('landing.check-report');

// Parent Portal & E-Raport Routes
Route::get('/raport/{portal_token}', [ParentPortalController::class, 'show'])->name('portal.show');
Route::get('/raport/{portal_token}/cetak-pdf', [ParentPortalController::class, 'downloadReportPdf'])->name('portal.download-raport');
Route::get('/raport/{portal_token}/kwitansi/{invoice_id}', [ParentPortalController::class, 'downloadInvoicePdf'])->name('portal.download-invoice');


