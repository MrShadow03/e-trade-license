<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\User\PasswordController;
use App\Http\Controllers\TradeLicensePaymentController;
use App\Http\Controllers\UserOneTimePasswordController;
use App\Http\Controllers\TradeLicenseLocationController;
use App\Http\Controllers\Auth\User\NewPasswordController;
use App\Http\Controllers\Auth\User\VerifyEmailController;
use App\Http\Controllers\TradeLicenseOwnershipController;
use App\Http\Controllers\Auth\User\RegisteredUserController;
use App\Http\Controllers\Auth\User\PasswordResetLinkController;
use App\Http\Controllers\User\TradeLicenseApplicationController;
use App\Http\Controllers\Auth\User\ConfirmablePasswordController;
use App\Http\Controllers\Auth\User\AuthenticatedSessionController;
use App\Http\Controllers\Auth\User\EmailVerificationPromptController;
use App\Http\Controllers\Auth\User\EmailVerificationNotificationController;


Route::group(['middleware' => ['auth:web', 'phone_verified'], 'as' => 'user.', 'prefix' => 'user'], function () {
    
    Route::group(['middleware' => 'has_pure_password'], function () {

        Route::get('/dashboard', function () {
            return redirect()->route('user.trade_license_applications');
        })->name('dashboard');
        
        // Application Routes...
        Route::group(['prefix' => 'trade-license-applications', 'as' => 'trade_license_applications'], function () {
            Route::get('/', [TradeLicenseApplicationController::class, 'index'])->name('');
            Route::get('/apply', [TradeLicenseApplicationController::class, 'create'])->name('.create');
            Route::post('/', [TradeLicenseApplicationController::class, 'store'])->name('.store');
            Route::get('/{trade_license_application}', [TradeLicenseApplicationController::class, 'show'])->name('.show');
            Route::get('/{trade_license_application}/edit', [TradeLicenseApplicationController::class, 'edit'])->name('.edit');
            Route::get('/{trade_license_application}/review', [TradeLicenseApplicationController::class, 'review'])->name('.review');
            Route::patch('/{trade_license_application}', [TradeLicenseApplicationController::class, 'update'])->name('.update');
            Route::patch('/{trade_license_application}/correction', [TradeLicenseApplicationController::class, 'correction'])->name('.correction');
            Route::delete('/{trade_license_application}', [TradeLicenseApplicationController::class, 'destroy'])->name('.destroy');

            // Application Renewal Routes...
            Route::patch('/{trade_license_application}/renew', [TradeLicenseApplicationController::class, 'renew'])->name('.renew');

            // Location change application routes...
            Route::get('/{trade_license_application}/change-location', [TradeLicenseLocationController::class, 'index'])->name('.change_location');
            Route::post('/{trade_license_application}/change-location', [TradeLicenseLocationController::class, 'store'])->name('.change_location.store');

            // Ownership change application routes...
            Route::get('/{trade_license_application}/change-ownership', [TradeLicenseOwnershipController::class, 'index'])->name('.change_ownership');
            Route::post('/{trade_license_application}/change-ownership', [TradeLicenseOwnershipController::class, 'store'])->name('.change_ownership.store');
            
            // Payment Routes...
            Route::post('/payments/form-fee', [TradeLicensePaymentController::class, 'storeFromFee'])->name('.payments.form_fee.store');
            Route::post('/payments/license-fee', [TradeLicensePaymentController::class, 'storeLicenseFee'])->name('.payments.license_fee.store');
            Route::post('/payments/license-renewal-fee', [TradeLicensePaymentController::class, 'storeLicenseRenewalFee'])->name('.payments.license_renewal_fee.store');
        });
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/password', [ProfileController::class, 'passwordUpdate'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::group(['middleware' => 'guest:web', 'as' => 'user.', 'prefix' => 'user'], function () {
    // Authentication Routes...
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('verify-otp', [UserOneTimePasswordController::class, 'create'])->name('verify-otp');
    Route::post('verify-otp/verify', [UserOneTimePasswordController::class, 'verify'])->name('verify-otp.verify');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.send');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});