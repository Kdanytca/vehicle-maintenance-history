<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehiculos/crear', [VehiculoController::class, 'create']);
Route::post('/vehiculos', [VehiculoController::class, 'store']);

/*
|--------------------------------------------------------------------------
| PBI #5 - Búsqueda de vehículos
|--------------------------------------------------------------------------
*/

Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda']);
Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar']);

/*
|--------------------------------------------------------------------------
| PBI #6 - Reporte de mantenimientos por placa
|--------------------------------------------------------------------------
*/

Route::get('/reportes/placa', [VehiculoController::class, 'formReporte']);
Route::get('/reportes/placa/buscar', [VehiculoController::class, 'reportePorPlaca']);