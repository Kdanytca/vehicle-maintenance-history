<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - SGA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-[#020617] text-slate-100">

    <!-- Barra superior -->
    <div class="bg-[#0f172a] border-b border-slate-800 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-users text-slate-900 text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-white">Gestión de Usuarios</h1>
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

    <!-- Contenido principal -->
    <div class="p-6">
        <!-- Mensajes de éxito/error -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div
                class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Botón crear nuevo usuario -->
        <div class="mb-6 flex justify-between items-center">
            <p class="text-slate-400 text-sm">Listado de todos los usuarios registrados en el sistema.</p>
            <a href="{{ route('usuarios.create') }}"
                class="bg-sky-500 hover:bg-sky-600 transition text-slate-900 px-4 py-2 rounded-lg font-semibold text-sm flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Nuevo Usuario
            </a>
        </div>

        <!-- Tabla de usuarios -->
        <div class="bg-[#1e293b] rounded-xl border border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-slate-800">
                            <th class="px-4 py-3 text-slate-400 font-semibold text-xs uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-slate-400 font-semibold text-xs uppercase tracking-wider">Usuario
                            </th>
                            <th class="px-4 py-3 text-slate-400 font-semibold text-xs uppercase tracking-wider">Rol</th>
                            <th class="px-4 py-3 text-slate-400 font-semibold text-xs uppercase tracking-wider">Estado
                            </th>
                            <th
                                class="px-4 py-3 text-slate-400 font-semibold text-xs uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($usuarios as $usuario)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-mono text-xs">{{ $usuario->id_usuario }}</td>
                                <td class="px-4 py-3 font-medium text-white">{{ $usuario->username }}</td>
                                <td class="px-4 py-3">
                                    @if ($usuario->rol)
                                        <span
                                            class="text-xs px-2 py-1 rounded-full 
                                        @if ($usuario->rol->nombre_rol === 'admin') bg-sky-500/10 text-sky-400 border border-sky-500/20
                                        @else bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 @endif">
                                            {{ ucfirst($usuario->rol->nombre_rol) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-500">Sin rol</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($usuario->estado_activo)
                                        <span
                                            class="text-xs bg-emerald-500/10 text-emerald-400 px-2 py-1 rounded-full border border-emerald-500/20">
                                            <i class="fa-solid fa-circle text-[6px] mr-1 align-middle"></i> Activo
                                        </span>
                                    @else
                                        <span
                                            class="text-xs bg-rose-500/10 text-rose-400 px-2 py-1 rounded-full border border-rose-500/20">
                                            <i class="fa-solid fa-circle text-[6px] mr-1 align-middle"></i> Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
                                        class="inline-block px-2 py-1 bg-slate-800 hover:bg-sky-500/20 text-sky-400 rounded text-xs transition">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>

                                    @if ($usuario->id_usuario !== auth()->id())
                                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('¿Estás seguro de deshabilitar este usuario?')"
                                                class="px-2 py-1 bg-slate-800 hover:bg-rose-500/20 text-rose-400 rounded text-xs transition">
                                                <i class="fa-solid fa-ban"></i> Deshabilitar
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-slate-800/50 text-slate-500 rounded text-xs cursor-not-allowed">
                                            <i class="fa-solid fa-lock"></i> Cuenta actual
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                    <i class="fa-solid fa-users-slash text-2xl mb-2 block"></i>
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if ($usuarios->hasPages())
                <div class="px-4 py-3 border-t border-slate-800">
                    {{ $usuarios->links() }}
                </div>
            @endif
        </div>
    </div>

</body>

</html>
