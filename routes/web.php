<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;

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

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
