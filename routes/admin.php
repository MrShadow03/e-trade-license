<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\Admin\PasswordController;
use App\Http\Controllers\TradeLicensePaymentController;
use App\Http\Controllers\Auth\Admin\NewPasswordController;
use App\Http\Controllers\Auth\Admin\VerifyEmailController;
use App\Http\Controllers\Auth\Admin\RegisteredUserController;
use App\Http\Controllers\Auth\Admin\PasswordResetLinkController;
use App\Http\Controllers\Admin\TradeLicenseApplicationController;
use App\Http\Controllers\Auth\Admin\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Admin\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Admin\EmailVerificationNotificationController;

Route::group(['middleware' => 'guest:admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::group(['middleware' => 'auth:admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Application Routes...
    Route::group(['prefix' => 'trade-license-applications', 'as' => 'trade_license_applications'], function () {
        Route::get('/', [TradeLicenseApplicationController::class, 'index'])->name('');
        Route::get('/{trade_license_application}', [TradeLicenseApplicationController::class, 'show'])->name('.show');
        Route::get('/{trade_license_application}/inspect', [TradeLicenseApplicationController::class, 'inspect'])->name('.inspect');
        Route::post('/verify-form-fee-payment', [TradeLicenseApplicationController::class, 'verifyFormFeePayment'])->name('.verify_form_fee_payment')->can('verify-form-fee-payment');
        Route::post('/verify-license-fee-payment', [TradeLicenseApplicationController::class, 'verifyLicenseFeePayment'])->name('.verify_license_fee_payment')->can('verify-license-fee-payment');

        // Approval Routes...
        // Assistant Approval
        Route::patch('/{trade_license_application}/approve', [TradeLicenseApplicationController::class, 'approve'])->name('.approve')->middleware('can_any:approve-pending-trade-license-assistant-approval-applications, approve-pending-trade-license-inspector-approval-applications, approve-pending-trade-license-superintendent-approval-applications, approve-pending-revenue-officer-approval-applications, approve-pending-chief-revenue-officer-approval-applications, approve-pending-chief-executive-officer-approval-applications');

    });

    Route::group(['prefix' => 'admins', 'as' => 'admins'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('');
        Route::post('/', [AdminController::class, 'store'])->name('.store');
    });




    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});