<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    // Listar mantenimientos
    public function index()
    {
        $mantenimientos = Mantenimiento::all();
        return view('mantenimientos.index', compact('mantenimientos'));
    }

}