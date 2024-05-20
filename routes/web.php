<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TradeLicenseController;

Route::get('/', function () {
    return redirect()->route('user.login');
})->name('home');
Route::get('/', function () {
    return redirect()->route('user.login');
})->name('login');

Route::get('/test', function () {
    return view('test');
});

Route::post('/test', [TestController::class, 'store'])->name('test.store');

Route::get('/trade-license/{uuid}', [TradeLicenseController::class, 'show'])->name('trade-license')->middleware(['auth']);

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
