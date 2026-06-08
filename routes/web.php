<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\HistorialVehiculoController;

// ==========================================
// 1. CONTROL DE RAÍZ Y AUTENTICACIÓN
// ==========================================

// Evita el bucle de redirecciones mandando a ambos roles a la pantalla común
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('vehiculos.index');
    }
    return redirect('/login');
});

// Rutas para usuarios no autenticados
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', ControllerLogin::class);
});

// Cierre de sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ==========================================
// 2. RUTAS PROTEGIDAS (REQUIEREN INICIO DE SESIÓN)
// ==========================================
Route::middleware('auth')->group(function () {

    // --------------------------------------
    // Módulo de Vehículos (Pantalla Principal Común)
    // --------------------------------------
    Route::get('/vehiculos/busqueda', [VehiculoController::class, 'busqueda'])->name('vehiculos.busqueda');
    Route::get('/vehiculos/buscar', [VehiculoController::class, 'buscar'])->name('vehiculos.buscar');
    Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear', [VehiculoController::class, 'create'])->name('vehiculos.create');
    Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');

    // Rutas para Ver y Editar
    Route::get('/vehiculos/{id}', [VehiculoController::class, 'show'])->name('vehiculos.show');
    Route::get('/vehiculos/{id}/editar', [VehiculoController::class, 'edit'])->name('vehiculos.edit');
    Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');

    // --------------------------------------
    // Módulo de Repuestos (Ambos Roles)
    // --------------------------------------
    Route::get('/repuestos', [RepuestoController::class, 'index'])->name('repuestos.index');
    Route::post('/repuestos/cargar-pdf', [RepuestoController::class, 'storeFromPdf'])->name('repuestos.storePdf');

    // --------------------------------------
    // Módulo de Alertas (Ambos Roles)
    // --------------------------------------
    Route::get('/alertas', [RepuestoController::class, 'alertas'])->name('notificaciones.index');
    Route::post('/notificaciones/enviar', [RepuestoController::class, 'enviarNotificacion'])->name('notificaciones.enviar');

    // --------------------------------------
    // Módulo de Mantenimientos (Ambos Roles)
    // --------------------------------------
    Route::resource('mantenimientos', MantenimientoController::class);

    // --------------------------------------
    // Módulo de Historial de Vehículos (Ambos Roles)
    // --------------------------------------
    Route::get('/historial-vehiculo', [HistorialVehiculoController::class, 'index'])->name('historial-vehiculo.index');

    // --------------------------------------
    // Módulo de Reportes (Ambos Roles)
    // --------------------------------------
    Route::get('/reportes/placa', [VehiculoController::class, 'formReporte'])->name('reportes.placa');
    Route::get('/reportes/placa/buscar', [VehiculoController::class, 'reportePorPlaca'])->name('reportes.buscar');


    // ==========================================
    // 3. RESTRICCIÓN: SOLO ADMINISTRADORES
    // ==========================================
    Route::middleware('solo.admin')->prefix('admin')->group(function () {

        // Ruta para el Panel Principal de Administración
        Route::get('/admin', function () {
            return view('admin.index'); // O el controlador que uses para tu dashboard principal
        })->name('admin.admin');

        // Gestión de Usuarios
        Route::name('usuarios.')->group(function () {
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

        // Gestión de Roles y Permisos
        Route::name('roles-permisos.')->group(function () {
            Route::get('/roles-permisos', [RolPermisoController::class, 'index'])->name('index');
            Route::post('/roles', [RolPermisoController::class, 'storeRol'])->name('store-rol');
            Route::delete('/roles/{id}', [RolPermisoController::class, 'destroyRol'])->name('destroy-rol');
            Route::post('/permisos', [RolPermisoController::class, 'storePermiso'])->name('store-permiso');
            Route::delete('/permisos/{id}', [RolPermisoController::class, 'destroyPermiso'])->name('destroy-permiso');
            Route::put('/roles/{id_rol}/permisos', [RolPermisoController::class, 'asignarPermisos'])->name('asignar');
        });
    });
});
