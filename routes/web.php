<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Models\Report;
use Illuminate\Http\Response;
use App\Http\Controllers\Alumni\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Alumni Portal Routes
Route::prefix('alumni')->name('alumni.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware(['guest:alumni', 'guest:web'])->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });

    // Authenticated alumni routes - ensure only alumni can access
    Route::middleware(['alumni'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    });
});

// Route for downloading reports
Route::get('/reports/{report}/download', function (Report $report) {
    if (!$report->is_completed || !$report->file_exists) {
        abort(404, 'Report file not found');
    }
    
    $filePath = storage_path('app/' . $report->file_path);
    $fileName = $report->title . '.' . $report->file_format;
    
    return response()->download($filePath, $fileName);
})->name('reports.download');
