<?php

use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\MantenimientoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\HistorialVehiculoController;

// ==========================================
// 1. MÓDULO DE AUTENTICACIÓN (LOGIN / LOGOUT)
// ==========================================

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', ControllerLogin::class);
});

Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda']);
Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar']);

Route::get('/reportes/placa', [VehiculoController::class, 'formReporte']);
Route::get('/reportes/placa/buscar', [VehiculoController::class, 'reportePorPlaca']);

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
    Route::get('/usuarios', \App\Http\Controllers\Usuarios\ListarUsuariosController::class)->name('index');
    Route::get('/usuarios/crear', function () {
        $roles = \App\Models\Rol::all();
        return view('usuarios.create', compact('roles'));
    })->name('create');
    Route::post('/usuarios', \App\Http\Controllers\Usuarios\CrearUsuarioController::class)->name('store');
    Route::get('/usuarios/{id}/editar', function ($id) {
        $usuario = \App\Models\Usuario::findOrFail($id);
        $roles = \App\Models\Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    })->name('edit');
    Route::put('/usuarios/{id}', \App\Http\Controllers\Usuarios\EditarUsuarioController::class)->name('update');
    Route::delete('/usuarios/{id}', \App\Http\Controllers\Usuarios\EliminarUsuarioController::class)->name('destroy');
});

// ==========================================
// 3. MÓDULO DE VEHÍCULOS
// ==========================================

Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda'])->name('vehiculos.busqueda');
Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar'])->name('vehiculos.buscar');

Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
Route::get('/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');

// CRUD / Gestión base de repuestos
Route::get('/repuestos', [RepuestoController::class, 'index'])->name('repuestos.index');
Route::post('/repuestos/cargar-pdf', [RepuestoController::class, 'storeFromPdf'])->name('repuestos.storePdf');

// Alertas y notificaciones
Route::get('/alertas', [RepuestoController::class, 'alertas'])->name('notificaciones.index');
Route::post('/notificaciones/enviar', [RepuestoController::class, 'enviarNotificacion'])->name('notificaciones.enviar');

// Mantenimientos
Route::resource('mantenimientos', MantenimientoController::class);

// ==========================================
// MÓDULO DE ROLES Y PERMISOS
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('roles-permisos.')->group(function () {
    Route::get('/roles-permisos', [RolPermisoController::class, 'index'])->name('index');
    Route::post('/roles', [RolPermisoController::class, 'storeRol'])->name('store-rol');
    Route::delete('/roles/{id}', [RolPermisoController::class, 'destroyRol'])->name('destroy-rol');
    Route::post('/permisos', [RolPermisoController::class, 'storePermiso'])->name('store-permiso');
    Route::delete('/permisos/{id}', [RolPermisoController::class, 'destroyPermiso'])->name('destroy-permiso');
    Route::put('/roles/{id_rol}/permisos', [RolPermisoController::class, 'asignarPermisos'])->name('asignar');
});

// ==========================================
// MÓDULO DE HISTORIAL DE VEHÍCULO
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/historial-vehiculo', [HistorialVehiculoController::class, 'index'])->name('historial-vehiculo.index');
});