<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Routes
Route::middleware('auth', 'userRole', 'verified')->group(function () {
    Route::get('/dashboard/user', [UserDashboard::class, 'index'])->name('dashboard');
});

// Admin Routes
Route::middleware('auth', 'adminRole')->group(function () {
    Route::get('/dashboard/admin', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});

// Google Login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('google.callback');

require __DIR__.'/auth.php';