<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Propietario;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
{
    $vehiculos = Vehiculo::with('propietario')->get();
    return view('vehiculos.index', compact('vehiculos'));
}
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

    /*
    |--------------------------------------------------------------------------
    | PBI #6 - Reporte por placa
    |--------------------------------------------------------------------------
    */

    public function formReporte()
    {
        return view('vehiculos.reporte');
    }

    public function reportePorPlaca(Request $request)
    {
        $request->validate([
            'placa' => 'required'
        ]);

        $placa = trim($request->placa);

        $vehiculo = Vehiculo::where('placa', $placa)->first();

        if (!$vehiculo) {
            return view('vehiculos.reporte', [
                'mensaje' => 'La placa ingresada no existe.'
            ]);
        }

        $mantenimientos = Mantenimiento::where(
            'id_vehiculo',
            $vehiculo->id_vehiculo
        )
        ->orderBy('fecha_servicio', 'asc')
        ->get();

        if ($mantenimientos->isEmpty()) {
            return view('vehiculos.reporte', [
                'mensaje' => 'No existen mantenimientos para esta placa.'
            ]);
        }

        return view('vehiculos.reporte', compact(
            'vehiculo',
            'mantenimientos'
        ));
    }
}