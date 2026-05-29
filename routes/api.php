<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Ruta de Login apuntando al controlador invocable
Route::post('/login', LoginController::class);