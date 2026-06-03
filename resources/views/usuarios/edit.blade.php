<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - SGA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#020617] text-slate-100">

    <!-- Barra superior -->
    <div class="bg-[#0f172a] border-b border-slate-800 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-user-pen text-slate-900 text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-white">Editar Usuario</h1>
                <span class="text-xs bg-slate-800 px-2 py-1 rounded text-slate-300">{{ $usuario->username }}</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('usuarios.index') }}" class="text-slate-400 hover:text-sky-400 transition text-sm">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Volver al Listado
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
    <div class="p-6 max-w-2xl mx-auto">

        <!-- Mensaje de advertencia para cuenta actual -->
        @if ($usuario->id_usuario === auth()->id())
            <div
                class="bg-amber-500/10 border border-amber-500/20 text-amber-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i>
                <span class="text-sm">Estás editando tu propia cuenta. Ten cuidado al cambiar el estado o rol.</span>
            </div>
        @endif

        <!-- Errores de validación -->
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span class="font-semibold">Errores de validación:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('usuarios.update', $usuario->id_usuario) }}"
            class="bg-[#1e293b] rounded-xl border border-slate-800 p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Username -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">
                    <i class="fa-solid fa-user mr-1"></i> Nombre de Usuario *
                </label>
                <input type="text" name="username" value="{{ old('username', $usuario->username) }}" required
                    class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-sky-500 transition">
                <p class="text-[11px] text-slate-500 mt-1">Mínimo 3 caracteres, único en el sistema.</p>
            </div>

            <!-- Contraseña (opcional) -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">
                    <i class="fa-solid fa-key mr-1"></i> Nueva Contraseña
                </label>
                <input type="password" name="password"
                    class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-sky-500 transition">
                <p class="text-[11px] text-slate-500 mt-1">Opcional. Déjalo en blanco si no deseas cambiar la
                    contraseña.</p>
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">
                    <i class="fa-solid fa-lock mr-1"></i> Confirmar Nueva Contraseña
                </label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-sky-500 transition">
            </div>

            <!-- Rol -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">
                    <i class="fa-solid fa-briefcase mr-1"></i> Rol *
                </label>
                <select name="id_rol" required
                    class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-sky-500 transition">
                    <option value="">Seleccione un rol</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id_rol }}"
                            {{ old('id_rol', $usuario->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                            {{ ucfirst($rol->nombre_rol) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Estado -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">
                    <i class="fa-solid fa-circle-info mr-1"></i> Estado
                </label>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="estado_activo" value="1"
                            {{ old('estado_activo', $usuario->estado_activo) == '1' ? 'checked' : '' }}
                            class="accent-sky-500">
                        <span class="text-sm text-slate-300">Activo</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="estado_activo" value="0"
                            {{ old('estado_activo', $usuario->estado_activo) == '0' ? 'checked' : '' }}
                            class="accent-rose-500">
                        <span class="text-sm text-slate-300">Inactivo</span>
                    </label>
                </div>
                @if ($usuario->id_usuario === auth()->id())
                    <p class="text-[11px] text-amber-400 mt-1">
                        <i class="fa-solid fa-warning mr-1"></i> Si desactivas tu propia cuenta, cerrarás sesión
                        automáticamente.
                    </p>
                @endif
            </div>

            <!-- Botones -->
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-sky-500 hover:bg-sky-600 transition text-slate-900 font-bold py-2.5 rounded-lg text-sm">
                    <i class="fa-solid fa-save mr-1"></i> Actualizar Usuario
                </button>
                <a href="{{ route('usuarios.index') }}"
                    class="px-6 bg-slate-800 hover:bg-slate-700 transition text-slate-300 font-semibold py-2.5 rounded-lg text-sm text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</body>

</html>
