<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles y Permisos - SGA</title>
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
                <div class="w-8 h-8 bg-violet-500 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-shield-halved text-slate-900 text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-white">Configurar Roles y Permisos</h1>
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

    <div class="p-6 max-w-7xl mx-auto">

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-lg mb-6">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                @foreach($errors->all() as $e) <span>{{ $e }}</span><br> @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="space-y-6">

                <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                    <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-tag text-violet-400"></i> Nuevo Rol
                    </h2>
                    <form method="POST" action="{{ route('roles-permisos.store-rol') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-xs text-slate-400 block mb-1">Nombre del rol</label>
                            <input type="text" name="nombre_rol" placeholder="ej. supervisor"
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-violet-500 transition"
                                required>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block mb-1">Descripción</label>
                            <input type="text" name="descripcion" placeholder="Funciones del rol"
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-violet-500 transition">
                        </div>
                        <button type="submit"
                            class="w-full bg-violet-600 hover:bg-violet-700 text-white py-2 rounded-lg text-sm font-semibold transition">
                            <i class="fa-solid fa-plus mr-1"></i> Crear Rol
                        </button>
                    </form>
                </div>

                <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                    <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-key text-amber-400"></i> Nuevo Permiso
                    </h2>
                    <form method="POST" action="{{ route('roles-permisos.store-permiso') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-xs text-slate-400 block mb-1">Nombre del permiso</label>
                            <input type="text" name="nombre_permiso" placeholder="ej. ver_reportes"
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500 transition"
                                required>
                        </div>
                        <div>
                            <label class="text-xs text-slate-400 block mb-1">Descripción</label>
                            <input type="text" name="descripcion" placeholder="Qué permite hacer"
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <button type="submit"
                            class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 rounded-lg text-sm font-semibold transition">
                            <i class="fa-solid fa-plus mr-1"></i> Crear Permiso
                        </button>
                    </form>
                </div>

                <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                    <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-amber-400"></i> Permisos del Sistema
                    </h2>
                    @forelse($permisos as $permiso)
                        <div class="flex items-center justify-between py-2 border-b border-slate-800/60 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-white">{{ $permiso->nombre_permiso }}</p>
                                @if($permiso->descripcion)
                                    <p class="text-xs text-slate-500">{{ $permiso->descripcion }}</p>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('roles-permisos.destroy-permiso', $permiso->id_permiso) }}">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar permiso?')"
                                    class="text-xs text-rose-400 hover:text-rose-300 transition px-2 py-1">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 text-center py-4">
                            <i class="fa-solid fa-inbox block text-2xl mb-2"></i>No hay permisos registrados.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-sm font-semibold text-slate-300 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-violet-400"></i> Roles y sus Permisos
                    </h2>
                    <span class="text-xs text-slate-500">{{ $roles->count() }} rol(es) registrado(s)</span>
                </div>

                @forelse($roles as $rol)
                    <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs px-2 py-1 rounded-full
                                        {{ $rol->nombre_rol === 'admin' ? 'bg-sky-500/10 text-sky-400 border border-sky-500/20' : 'bg-violet-500/10 text-violet-400 border border-violet-500/20' }}">
                                        {{ ucfirst($rol->nombre_rol) }}
                                    </span>
                                    <span class="text-xs text-slate-500">{{ $rol->permisos->count() }} permiso(s)</span>
                                </div>
                                @if($rol->descripcion)
                                    <p class="text-xs text-slate-500 mt-1">{{ $rol->descripcion }}</p>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('roles-permisos.destroy-rol', $rol->id_rol) }}">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar el rol {{ $rol->nombre_rol }}?')"
                                    class="text-xs text-rose-400 hover:text-rose-300 transition px-2 py-1 rounded border border-rose-500/20 hover:border-rose-400/40">
                                    <i class="fa-solid fa-trash mr-1"></i> Eliminar
                                </button>
                            </form>
                        </div>

                        <form method="POST" action="{{ route('roles-permisos.asignar', $rol->id_rol) }}">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-4">
                                @foreach($permisos as $permiso)
                                    <label class="flex items-center gap-2 bg-slate-900/50 border border-slate-700/50 rounded-lg px-3 py-2 cursor-pointer hover:border-violet-500/50 transition group">
                                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id_permiso }}"
                                            {{ $rol->permisos->contains('id_permiso', $permiso->id_permiso) ? 'checked' : '' }}
                                            class="accent-violet-500 w-4 h-4">
                                        <span class="text-xs text-slate-300 group-hover:text-white transition truncate">
                                            {{ $permiso->nombre_permiso }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @if($permisos->isEmpty())
                                <p class="text-xs text-slate-500 mb-3">
                                    <i class="fa-solid fa-info-circle mr-1"></i>
                                    Primero crea permisos en el panel izquierdo para asignarlos.
                                </p>
                            @endif

                            <button type="submit"
                                class="bg-violet-600/20 hover:bg-violet-600/40 border border-violet-500/30 text-violet-300 px-4 py-2 rounded-lg text-xs font-semibold transition">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar cambios
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-[#1e293b] rounded-xl border border-slate-800 p-10 text-center">
                        <i class="fa-solid fa-shield-halved text-4xl text-slate-600 mb-3 block"></i>
                        <p class="text-slate-500">No hay roles registrados. Crea el primero.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>