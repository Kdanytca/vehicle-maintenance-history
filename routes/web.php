<?php

use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// 1. MÓDULO DE AUTENTICACIÓN (LOGIN / LOGOUT)
// ==========================================

// Redirigir la raíz al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de acceso para invitados (No logueados)
Route::middleware('guest')->group(function () {
    // Mostrar formulario de login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // Procesar login (Controlador invocable)
    Route::post('/login', ControllerLogin::class);
});

// Cerrar sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ==========================================
// 2. VISTAS PRINCIPALES POR ROL (PROTEGIDAS)
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get('/auth/admin', function () {
        return view('auth.admin');
    })->name('admin.admin');

    Route::get('/auth/mecanico', function () {
        return view('auth.mecanico');
    })->name('mecanico.mecanico');
});


// ==========================================
// 3. MÓDULO DE VEHÍCULOS 
// ==========================================

// PBI #5 - Búsqueda de vehículos (Primero las rutas específicas)
Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda'])->name('vehiculos.busqueda');
Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar'])->name('vehiculos.buscar');

// CRUD / Gestión base de vehículos
Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
Route::get('/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');