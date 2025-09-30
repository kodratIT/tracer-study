<?php

use Illuminate\Support\Facades\Route;
use Modules\Employment\Http\Controllers\EmploymentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('employments', EmploymentController::class)->names('employment');
});
