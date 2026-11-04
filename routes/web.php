<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ParentPortalController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrialLeadController;
use App\Http\Controllers\TuitionInvoiceController;
use Illuminate\Support\Facades\Route;

// Web Customer / Public Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::post('/daftar-trial', [LandingController::class, 'storeTrial'])->name('landing.store-trial');
Route::get('/cek-raport', [LandingController::class, 'checkReport'])->name('landing.check-report');

// Parent Portal & E-Raport Routes
Route::get('/raport/{portal_token}', [ParentPortalController::class, 'show'])->name('portal.show');
Route::get('/raport/{portal_token}/cetak-pdf', [ParentPortalController::class, 'downloadReportPdf'])->name('portal.download-raport');
Route::get('/raport/{portal_token}/kwitansi/{invoice_id}', [ParentPortalController::class, 'downloadInvoicePdf'])->name('portal.download-invoice');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin & Tutor Portal Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/journal', [AttendanceController::class, 'saveJournal'])->name('attendance.journal');
    Route::get('/leads', [TrialLeadController::class, 'index'])->name('leads.index');
    Route::patch('/leads/{lead}/status', [TrialLeadController::class, 'updateStatus'])->name('leads.status');
    Route::post('/leads/{lead}/convert', [TrialLeadController::class, 'convertToStudent'])->name('leads.convert');
    Route::delete('/leads/{lead}', [TrialLeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/invoices', [TuitionInvoiceController::class, 'index'])->name('invoices.index');
});




