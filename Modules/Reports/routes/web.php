<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix('reports')->name('reports.')->group(function () {
    
    // Export download route
    Route::get('/export/download/{file}', function (string $file) {
        $filePath = 'exports/' . $file;
        
        if (!Storage::exists($filePath)) {
            abort(404, 'Export file not found');
        }
        
        $fullPath = Storage::path($filePath);
        $originalName = $file;
        
        // Determine content type based on extension
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $contentType = match(strtolower($extension)) {
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'pdf' => 'application/pdf',
            'csv' => 'text/csv',
            default => 'application/octet-stream',
        };
        
        return response()->download($fullPath, $originalName, [
            'Content-Type' => $contentType,
        ]);
    })->name('export.download');
});
