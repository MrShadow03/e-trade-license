<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\TradeLicenseController;

Route::get('/', function () {
    return redirect()->route('user.login');
})->name('home');
Route::get('/', function () {
    return redirect()->route('user.login');
})->name('login');

Route::get('/test', [TestController::class, 'index']);

Route::post('/test', [TestController::class, 'store'])->name('test.store');

Route::get('/trade-license/{uuid}', [TradeLicenseController::class, 'show'])->name('trade-license')->middleware(['auth']);
Route::get('/api/v1/users/{nid}', [UserController::class, 'show'])->name('api.v1.user.show')->middleware(['auth']);

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
