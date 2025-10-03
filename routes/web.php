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
        
        // Employment Routes
        Route::get('/employment/search-employers', [App\Http\Controllers\Alumni\EmploymentController::class, 'searchEmployers'])->name('employment.search-employers');
        Route::resource('employment', App\Http\Controllers\Alumni\EmploymentController::class)->except(['show']);
        
        // Survey/Tracer Study Routes
        Route::prefix('survey')->name('survey.')->group(function () {
            Route::get('/', [App\Http\Controllers\Alumni\SurveyController::class, 'index'])->name('index');
            Route::get('/{session}', [App\Http\Controllers\Alumni\SurveyController::class, 'show'])->name('show');
            Route::post('/{session}/start', [App\Http\Controllers\Alumni\SurveyController::class, 'start'])->name('start');
            Route::get('/response/{response}/questionnaire', [App\Http\Controllers\Alumni\SurveyController::class, 'questionnaire'])->name('questionnaire');
            Route::post('/response/{response}/answer', [App\Http\Controllers\Alumni\SurveyController::class, 'answer'])->name('answer');
            Route::post('/response/{response}/save-draft', [App\Http\Controllers\Alumni\SurveyController::class, 'saveDraft'])->name('save-draft');
            Route::get('/response/{response}/review', [App\Http\Controllers\Alumni\SurveyController::class, 'review'])->name('review');
            Route::post('/response/{response}/submit', [App\Http\Controllers\Alumni\SurveyController::class, 'submit'])->name('submit');
            Route::get('/response/{response}/success', [App\Http\Controllers\Alumni\SurveyController::class, 'success'])->name('success');
        });
    });
});

// Wilayah API Proxy Routes
Route::get('/api/wilayah/provinces', [App\Http\Controllers\WilayahController::class, 'provinces'])->name('api.wilayah.provinces');
Route::get('/api/wilayah/regencies/{provinceCode}', [App\Http\Controllers\WilayahController::class, 'regencies'])->name('api.wilayah.regencies');
Route::get('/api/wilayah/districts/{regencyCode}', [App\Http\Controllers\WilayahController::class, 'districts'])->name('api.wilayah.districts');
Route::get('/api/wilayah/villages/{districtCode}', [App\Http\Controllers\WilayahController::class, 'villages'])->name('api.wilayah.villages');

// Route for downloading reports
Route::get('/reports/{report}/download', function (Report $report) {
    if (!$report->is_completed || !$report->file_exists) {
        abort(404, 'Report file not found');
    }
    
    $filePath = storage_path('app/' . $report->file_path);
    $fileName = $report->title . '.' . $report->file_format;
    
    return response()->download($filePath, $fileName);
})->name('reports.download');
