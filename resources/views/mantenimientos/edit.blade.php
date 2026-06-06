@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-white mb-6">Modificar Mantenimiento</h1>

    <form action="{{ route('mantenimientos.update', $mantenimiento->id_mantenimiento) }}" method="POST" class="bg-[#1e293b] rounded-xl border border-slate-800 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1">Fecha del servicio *</label>
            <input type="date" name="fecha_servicio" value="{{ $mantenimiento->fecha_servicio }}" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-slate-200">
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1">Descripción de la falla *</label>
            <textarea name="descripcion_falla" rows="3" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-slate-200">{{ $mantenimiento->descripcion_falla }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1">Estado *</label>
            <select name="estado" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-slate-200">
                <option value="pendiente" {{ $mantenimiento->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_proceso" {{ $mantenimiento->estado == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="completado" {{ $mantenimiento->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                <option value="cancelado" {{ $mantenimiento->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1">Costo mano de obra</label>
            <input type="number" step="0.01" name="costo_mano_obra" value="{{ $mantenimiento->costo_mano_obra }}" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-slate-200">
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-1">ID del vehículo *</label>
            <input type="number" name="id_vehiculo" value="{{ $mantenimiento->id_vehiculo }}" required class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-slate-200">
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-slate-900 px-4 py-2 rounded-lg font-bold text-sm">Actualizar</button>
            <a href="{{ route('mantenimientos.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-4 py-2 rounded-lg text-sm">Cancelar</a>
        </div>
    </form>
</div>
@endsection