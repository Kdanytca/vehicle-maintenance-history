<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehiculos/crear', [VehiculoController::class, 'create']);
Route::post('/vehiculos', [VehiculoController::class, 'store']);