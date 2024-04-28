<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.login');
})->name('home');
Route::get('/', function () {
    return redirect()->route('user.login');
})->name('login');

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
