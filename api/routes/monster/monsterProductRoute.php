<?php

use App\Http\Controllers\Monster\MonsterProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('monsters', MonsterProductController::class);
