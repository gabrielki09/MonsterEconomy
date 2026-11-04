<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('v1')->group(function() {
    require __DIR__."/vehicle/vehicleRoutes.php";
});
