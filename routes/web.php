<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\LoanManagementController;
use App\Http\Controllers\LoanApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoanApplicationController::class, 'home'])->name('home');
Route::get('/eligibility-check', [LoanApplicationController::class, 'eligibilityForm'])->name('loan.eligibility');
Route::post('/eligibility-check', [LoanApplicationController::class, 'submitEligibility'])->name('loan.eligibility.submit');

Route::get('/loan-offer/{loanApplication}', [LoanApplicationController::class, 'showOffer'])->name('loan.offer');
Route::get('/loan/{loanApplication}/payment', [LoanApplicationController::class, 'showPaymentForm'])->name('loan.payment');
Route::post('/loan/{loanApplication}/payment', [LoanApplicationController::class, 'storePayment'])->name('loan.payment.store');
Route::get('/loan/{loanApplication}/payment/success', [LoanApplicationController::class, 'paymentSuccess'])->name('loan.payment.success');

Route::get('/contact', [LoanApplicationController::class, 'contact'])->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin')->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [LoanManagementController::class, 'dashboard'])->name('dashboard');
        Route::get('/loan-applications', [LoanManagementController::class, 'index'])->name('loan-applications.index');
        Route::get('/loan-applications/{loanApplication}', [LoanManagementController::class, 'show'])->name('loan-applications.show');
        Route::patch('/loan-applications/{loanApplication}', [LoanManagementController::class, 'updateStatus'])->name('loan-applications.update');
        Route::patch('/payments/{payment}', [LoanManagementController::class, 'updatePaymentStatus'])->name('payments.update');
    });
});
