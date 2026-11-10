<?php

use App\Http\Controllers\Location\LocationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('location', LocationController::class);
Route::controller(LocationController::class)->prefix('location')->group(function() {
    Route::get('restore', 'restore');

    Route::get('{location}/opening-hours', 'getOpeningHours');
});
