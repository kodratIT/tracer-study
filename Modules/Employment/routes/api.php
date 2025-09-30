<?php

use Illuminate\Support\Facades\Route;
use Modules\Employment\Http\Controllers\EmploymentController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('employments', EmploymentController::class)->names('employment');
});
