<?php

use Illuminate\Support\Facades\Route;
use Modules\Skill\Http\Controllers\SkillController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('skills', SkillController::class)->names('skill');
});
