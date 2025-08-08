<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Admin Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

// Admin Protected Routes
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Logout routes - support both GET and POST
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout.get');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    Route::resource('/events', EventController::class)->names('admin.events');
    Route::resource('/users', UserController::class)->names('admin.users');
    Route::get('/certificates', [AdminController::class, 'certificates'])->name('admin.certificates');
});