<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventJoinController;
use App\Http\Controllers\DashboardController;
use SplFileObject;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Homepage route
Route::get('/', function () {
    return view('welcome');
});

// Routes that require login + email verification
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Event join/leave routes
    Route::prefix('events/{event}')->name('events.')->group(function () {
        Route::post('/join', [EventJoinController::class, 'join'])->name('join');
        Route::delete('/leave', [EventJoinController::class, 'leave'])->name('leave');
    });
});

// Show last 100 lines of the Laravel log
Route::get('/show-log', function () {
    $logFile = storage_path('logs/laravel.log');

    if (!file_exists($logFile)) {
        return 'Log file does not exist.';
    }

    // Read last 100 lines of the log file to avoid memory issues
    $lines = [];
    $file = new SplFileObject($logFile, 'r');
    $file->seek(PHP_INT_MAX);
    $lastLine = $file->key();

    $start = max(0, $lastLine - 100);
    for ($i = $start; $i <= $lastLine; $i++) {
        $file->seek($i);
        $lines[] = htmlspecialchars($file->current()); // Escaping HTML for security
    }

    return '<pre>' . implode('', $lines) . '</pre>';
});

// Alternative route to show last 100 lines (could be removed if not needed)
Route::get('view-logs', function () {
    $logFile = storage_path('logs/laravel.log');

    if (file_exists($logFile)) {
        // Read last 100 lines of the log file
        $logs = array_slice(file($logFile), -100);

        // Return the logs as a string with line breaks
        return nl2br(implode('', $logs));
    } else {
        return "Log file does not exist.";
    }
});

require __DIR__.'/auth.php';
