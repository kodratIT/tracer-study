<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Models\Report;
use Illuminate\Http\Response;

Route::get('/', function () {
    return view('welcome');
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
