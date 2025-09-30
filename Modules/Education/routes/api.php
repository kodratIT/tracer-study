<?php

use Illuminate\Support\Facades\Route;
use Modules\Education\Http\Controllers\EducationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('education', EducationController::class)->names('education');
});
