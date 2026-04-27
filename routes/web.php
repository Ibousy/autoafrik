<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

// ── Auth (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
});

// ── Authenticated routes (garage users)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Garage subscription renewal
    Route::get('/abonnement/renouveler',  [RenewalController::class, 'show'])->name('renewal.show');
    Route::post('/abonnement/renouveler', [RenewalController::class, 'store'])->name('renewal.store');
});

// ── Super Admin panel
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/',                  [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/garages',           [SuperAdminController::class, 'companies'])->name('companies');
    Route::get('/garages/{company}', [SuperAdminController::class, 'showCompany'])->name('company.show');
    Route::patch('/garages/{company}', [SuperAdminController::class, 'updateCompany'])->name('company.update');

    Route::get('/abonnements',                         [SuperAdminController::class, 'renewals'])->name('renewals');
    Route::post('/abonnements/{renewal}/approuver',    [SuperAdminController::class, 'approveRenewal'])->name('renewal.approve');
    Route::post('/abonnements/{renewal}/rejeter',      [SuperAdminController::class, 'rejectRenewal'])->name('renewal.reject');
});
