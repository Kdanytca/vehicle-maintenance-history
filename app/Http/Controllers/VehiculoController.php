<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Propietario;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::with('propietario')->get();

        return view('vehiculos.index', compact('vehiculos'));
    }
}