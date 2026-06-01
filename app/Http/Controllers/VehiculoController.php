<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Propietario;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|unique:vehiculos,placa',
            'marca' => 'required',
            'modelo' => 'required',
            'propietario' => 'required',
        ]);

        $propietario = Propietario::create([
            'nombre' => $request->propietario,
            'documento_identidad' => 'N/A',
            'telefono' => 'N/A',
            'correo' => 'N/A'
        ]);

        Vehiculo::create([
            'placa' => $request->placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'id_propietario' => $propietario->id_propietario
        ]);

        return redirect()
            ->back()
            ->with('success', 'Vehículo registrado correctamente.');
    }

    public function busqueda()
    {
        return view('vehiculos.busqueda');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'termino' => 'required'
        ]);

        $termino = $request->termino;

        $vehiculos = Vehiculo::where('placa', 'like', '%' . $termino . '%')
            ->orWhereIn('id_propietario', function ($query) use ($termino) {
                $query->select('id_propietario')
                      ->from('propietarios')
                      ->where('nombre', 'like', '%' . $termino . '%');
            })
            ->get();

        return view('vehiculos.busqueda', compact('vehiculos'));
    }
}