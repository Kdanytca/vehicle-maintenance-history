<?php

use App\Http\Controllers\ControllerLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Auth;

// ========== RUTAS PÚBLICAS ==========

// Redirigir la raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Mostrar formulario de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Procesar login (controlador invocable)
Route::post('/login', ControllerLogin::class);

// Cerrar sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ========== RUTAS PROTEGIDAS (requieren autenticación) ==========

Route::middleware('auth')->group(function () {

    Route::get('/auth/admin', function () {
        return view('auth.admin');
    })->name('admin.admin');

    Route::get('/auth/mecanico', function () {
        return view('auth.mecanico');
    })->name('mecanico.mecanico');
});

Route::get('/vehiculos', [VehiculoController::class, 'index']);
Route::get('/vehiculos/crear', [VehiculoController::class, 'create']);
Route::post('/vehiculos', [VehiculoController::class, 'store']);

/*
|--------------------------------------------------------------------------
| PBI #5 - Búsqueda de vehículos
|--------------------------------------------------------------------------
*/

Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda']);
Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar']);
