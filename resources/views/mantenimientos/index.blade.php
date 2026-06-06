@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Listado de Mantenimientos</h1>
        <a href="{{ route('mantenimientos.create') }}" class="bg-sky-500 hover:bg-sky-600 text-slate-900 px-4 py-2 rounded-lg font-bold text-sm">
            <i class="fa-solid fa-plus"></i> Nuevo Mantenimiento
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 px-4 py-2 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#1e293b] rounded-xl border border-slate-800 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-900/50 border-b border-slate-800">
                <tr class="text-slate-400 text-xs font-semibold uppercase">
                    <th class="p-4">ID</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Descripción</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4">Vehículo</th>
                    <th class="p-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @foreach($mantenimientos as $m)
                <tr class="hover:bg-slate-800/30">
                    <td class="p-4 font-mono text-xs">{{ $m->id_mantenimiento }}</td>
                    <td class="p-4">{{ $m->fecha_servicio }}</td>
                    <td class="p-4 max-w-xs truncate">{{ $m->descripcion_falla }}</td>
        
                    <td class="p-4">
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($m->estado == 'pendiente') bg-amber-500/10 text-amber-400
                            @elseif($m->estado == 'en_proceso') bg-blue-500/10 text-blue-400
                            @elseif($m->estado == 'completado') bg-emerald-500/10 text-emerald-400
                            @else bg-rose-500/10 text-rose-400
                            @endif">
                            {{ $m->estado }}
                        </span>
                    </td>
                    <td class="p-4">{{ $m->vehiculo->placa ?? 'N/A' }}</td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('mantenimientos.edit', $m->id_mantenimiento) }}" class="inline-block p-1.5 bg-slate-800 hover:bg-sky-500/20 text-sky-400 rounded text-xs">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('mantenimientos.destroy', $m->id_mantenimiento) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Cancelar este mantenimiento?')" class="p-1.5 bg-slate-800 hover:bg-rose-500/20 text-rose-400 rounded text-xs">
                                <i class="fa-solid fa-ban"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection