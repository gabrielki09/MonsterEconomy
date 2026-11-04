<?php

use App\Http\Controllers\Vehicle\VehicleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('vehicle', VehicleController::class);
