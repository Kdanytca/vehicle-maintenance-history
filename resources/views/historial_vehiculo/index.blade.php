<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Vehículo - SGA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
    </style>
</head>
<body class="bg-[#020617] text-slate-100 min-h-screen">

    <div class="bg-[#0f172a] border-b border-slate-800 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-clock-rotate-left text-slate-900 text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-white">Historial de Cambios por Vehículo</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.admin') }}" class="text-slate-400 hover:text-sky-400 transition text-sm">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Volver al Panel
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-400 transition text-sm">
                        <i class="fa-solid fa-sign-out-alt mr-1"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="p-6 max-w-6xl mx-auto">

        <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5 mb-6">
            <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-sky-400"></i> Seleccionar Vehículo
            </h2>
            <form method="GET" action="{{ route('historial-vehiculo.index') }}" class="flex flex-col sm:flex-row gap-3">
                <select name="id_vehiculo" required
                    class="flex-1 bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-sky-500 transition">
                    <option value="">-- Seleccione un vehículo --</option>
                    @foreach($vehiculos as $v)
                        <option value="{{ $v->id_vehiculo }}"
                            {{ (isset($vehiculo) && $vehiculo->id_vehiculo == $v->id_vehiculo) ? 'selected' : '' }}>
                            {{ $v->placa }} — {{ $v->marca }} {{ $v->modelo }} {{ $v->anio }}
                            ({{ $v->propietario->nombre ?? 'Sin propietario' }})
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-sky-500 hover:bg-sky-600 text-slate-900 font-semibold px-5 py-2 rounded-lg text-sm transition whitespace-nowrap">
                    <i class="fa-solid fa-search mr-1"></i> Ver Historial
                </button>
            </form>
        </div>

        @if($vehiculo)
            <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-sky-500/10 border border-sky-500/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-car text-sky-400 text-lg"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-bold text-white">{{ $vehiculo->placa }}</span>
                            <span class="text-xs bg-sky-500/10 text-sky-400 border border-sky-500/20 px-2 py-0.5 rounded-full">
                                {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-400">
                            Año: {{ $vehiculo->anio }} &nbsp;|&nbsp;
                            Propietario: {{ $vehiculo->propietario->nombre ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-2xl font-bold text-white">{{ $mantenimientos->count() }}</p>
                        <p class="text-xs text-slate-400">mantenimiento(s)</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#1e293b] rounded-xl border border-slate-800 overflow-hidden mb-6">
                <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-wrench text-emerald-400"></i>
                    <h2 class="font-semibold text-white">Mantenimientos Registrados</h2>
                    <span class="ml-auto text-xs text-slate-500">{{ $mantenimientos->count() }} registro(s)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-900/50 border-b border-slate-800">
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Fecha</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Descripción</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Costo M.O.</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60">
                            @forelse($mantenimientos as $m)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-300">{{ $m->fecha_servicio }}</td>
                                    <td class="px-4 py-3 text-slate-200 max-w-xs truncate">{{ $m->descripcion_falla }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $colores = [
                                                'completado' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'en_proceso' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                                'pendiente'  => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                                'cancelado'  => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            ];
                                            $clase = $colores[$m->estado] ?? 'bg-slate-500/10 text-slate-400 border-slate-500/20';
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full border {{ $clase }}">
                                            {{ ucfirst(str_replace('_', ' ', $m->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-300 font-mono text-xs">
                                        {{ $m->costo_mano_obra ? '$' . number_format($m->costo_mano_obra, 2) : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                                        <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                                        No hay mantenimientos registrados para este vehículo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-[#1e293b] rounded-xl border border-slate-800 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-violet-400"></i>
                    <h2 class="font-semibold text-white">Historial de Auditoría</h2>
                    <span class="text-xs text-slate-500 ml-1">(eventos del sistema relacionados con este vehículo)</span>
                    <span class="ml-auto text-xs text-slate-500">{{ $historial->count() }} evento(s)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-900/50 border-b border-slate-800">
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Fecha</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipo Evento</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Descripción</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Usuario</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60">
                            @forelse($historial as $h)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-400 whitespace-nowrap">
                                        {{ $h->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badge = match($h->tipo_evento) {
                                                'AUDITORIA_CAMBIO' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                                'LOGIN_FALLIDO'    => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                                'LOG_SISTEMA'      => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                                default            => 'bg-violet-500/10 text-violet-400 border-violet-500/20',
                                            };
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full border {{ $badge }}">
                                            {{ $h->tipo_evento }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-200 max-w-sm">{{ $h->descripcion_evento }}</td>
                                    <td class="px-4 py-3 text-slate-400 text-xs">{{ $h->usuario->username ?? '—' }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $h->direccion_ip ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                        <i class="fa-solid fa-circle-info text-2xl mb-2 block"></i>
                                        No hay eventos de auditoría vinculados a este vehículo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-16 text-center">
                <i class="fa-solid fa-car-side text-5xl text-slate-700 mb-4 block"></i>
                <p class="text-slate-400 font-medium">Selecciona un vehículo para ver su historial completo.</p>
                <p class="text-slate-600 text-sm mt-1">Verás sus mantenimientos y eventos de auditoría.</p>
            </div>
        @endif

    </div>

</body>
</html>