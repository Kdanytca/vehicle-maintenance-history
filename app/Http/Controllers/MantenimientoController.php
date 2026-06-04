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

    // Mostrar formulario de crear
    public function create()
    {
        $vehiculos = Vehiculo::all();
        return view('mantenimientos.create', compact('vehiculos'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'fecha_servicio' => 'required|date',
            'descripcion_falla' => 'required|string',
            'estado' => 'required|string',
            'costo_mano_obra' => 'nullable|numeric',
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo'
        ]);
    
        Mantenimiento::create($request->all());
    
        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento registrado exitosamente.');
    }

    public function edit($id)
{
    $mantenimiento = Mantenimiento::findOrFail($id);
    return view('mantenimientos.edit', compact('mantenimiento'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'fecha_servicio' => 'required|date',
        'descripcion_falla' => 'required|string',
        'estado' => 'required|string',
        'costo_mano_obra' => 'nullable|numeric',
        'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo'
    ]);

    $mantenimiento = Mantenimiento::findOrFail($id);
    $mantenimiento->update($request->all());

    return redirect()->route('mantenimientos.index')
        ->with('success', 'Mantenimiento actualizado exitosamente.');
}
}