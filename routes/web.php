<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingsController;

// ─── Landing Page NIM (existante) ────────────────────────────────────────────
Route::get('/', [LandingController::class, 'index']);

// ─── Landing Page Inscription ─────────────────────────────────────────────────
Route::get('/inscription', [InscriptionController::class, 'index'])->name('inscription');
Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── Admin (protégé) ──────────────────────────────────────────────────────────
Route::middleware(\App\Http\Middleware\AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/leads', [AdminDashboardController::class, 'leads'])->name('leads');
    Route::get('/leads/export', [AdminDashboardController::class, 'exportCsv'])->name('leads.export');
    Route::get('/leads/{lead}', [AdminDashboardController::class, 'showLead'])->name('leads.show');
    Route::post('/leads/{lead}/status', [AdminDashboardController::class, 'updateStatus'])->name('leads.status');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/test', [AdminSettingsController::class, 'testMail'])->name('settings.test');
});
