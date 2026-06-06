<?php

use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RepuestoController;

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

Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda']);
Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar']);

/*
|--------------------------------------------------------------------------
| PBI #6 - Reporte de mantenimientos por placa
|--------------------------------------------------------------------------
*/

Route::get('/reportes/placa', [VehiculoController::class, 'formReporte']);
Route::get('/reportes/placa/buscar', [VehiculoController::class, 'reportePorPlaca']);
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
// MODULO DE GESTIÓN DE USUARIOS (SOLO ADMIN)
// ==========================================

Route::middleware(['auth'])->prefix('admin')->name('usuarios.')->group(function () {
    // Listar usuarios
    Route::get('/usuarios', \App\Http\Controllers\Usuarios\ListarUsuariosController::class)->name('index');
    // Mostrar formulario de creacion
    Route::get('/usuarios/crear', function () {
        $roles = \App\Models\Rol::all();
        return view('usuarios.create', compact('roles'));
    })->name('create');

    // Guardar nuevo usuario
    Route::post('/usuarios', \App\Http\Controllers\Usuarios\CrearUsuarioController::class)->name('store');

    // Mostrar formulario de edicion
    Route::get('/usuarios/{id}/editar', function ($id) {
        $usuario = \App\Models\Usuario::findOrFail($id);
        $roles = \App\Models\Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    })->name('edit');

    // Actualizar usuario 
    Route::put('/usuarios/{id}', \App\Http\Controllers\Usuarios\EditarUsuarioController::class)->name('update');

    // Deshabilitar usuario 
    Route::delete('/usuarios/{id}', \App\Http\Controllers\Usuarios\EliminarUsuarioController::class)
        ->name('destroy');
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



Route::get('/repuestos', [RepuestoController::class, 'index'])->name('repuestos.index');
Route::post('/repuestos/cargar-pdf', [RepuestoController::class, 'storeFromPdf'])->name('repuestos.storePdf');
Route::post('/notificaciones/enviar', [RepuestoController::class, 'enviarNotificacion'])->name('notificaciones.enviar');
