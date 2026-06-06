<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGA - Gestión de Repuestos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

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

<body class="bg-[#0f172a] text-slate-100 min-h-screen flex antialiased">

    <aside class="w-64 bg-[#1e293b] border-r border-slate-800 flex flex-col justify-between fixed h-full z-20">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-slate-800 gap-3">
                <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center text-slate-900 font-bold text-lg shadow-lg">
                    <i class="fa-solid fa-wrench text-sm"></i>
                </div>
                <div>
                    <span class="font-bold text-white tracking-wide block text-sm">SGA SYSTEM</span>
                    <span class="text-[10px] text-sky-400 font-semibold tracking-wider uppercase block">Taller Automotriz</span>
                </div>
            </div>
            <nav class="p-4 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-slate-200">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all bg-sky-500/10 text-sky-400 border border-sky-500/20 justify-between">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-cubes w-5 text-center"></i> Repuestos</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-slate-200 justify-between">
                    <span class="flex items-center gap-3"><i class="fa-solid fa-envelope w-5 text-center"></i> Alertas</span>
                    <span class="bg-amber-500/20 text-amber-400 text-[10px] px-1.5 py-0.5 rounded-full font-bold border border-amber-500/30">Novedades</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-800 bg-[#172033]">
            <p class="text-xs font-semibold text-slate-200">Óscar Pérez</p>
            <p class="text-[10px] text-slate-400">Administrador</p>
        </div>
    </aside>

    <div class="pl-64 flex flex-col flex-1 min-h-screen">
        <header class="h-16 border-b border-slate-800 flex items-center justify-between px-8 bg-[#0f172a]/80 backdrop-blur sticky top-0 z-10">
            <div class="flex items-center gap-3 w-96">
                <i class="fa-solid fa-magnifying-glass text-slate-500 text-sm"></i>
                <input type="text" placeholder="Búsqueda rápida..." class="bg-transparent border-none text-sm text-slate-300 focus:outline-none w-full">
            </div>
        </header>

        <main class="p-8 space-y-8 flex-1">

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight">Inventario de Repuestos y Reposición</h1>
                        <p class="text-sm text-slate-400">Control de stock mínimo, garantías asociadas y vinculación de comprobantes de compra desde MySQL.</p>
                    </div>
                    <button onclick="openModal('modal-repuesto')" class="bg-sky-500 hover:bg-sky-600 transition-all text-slate-900 px-4 py-2 rounded-lg font-semibold text-sm flex items-center gap-2 shadow-md cursor-pointer">
                        <i class="fa-solid fa-file-arrow-up text-xs"></i> Cargar Factura de Compra
                    </button>
                </div>

                <div class="bg-[#1e293b] rounded-xl border border-slate-800 overflow-hidden shadow-sm">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-900/50 border-b border-slate-800 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                                <th class="p-4">Código Pieza</th>
                                <th class="p-4">Nombre / Descripción</th>
                                <th class="p-4">Precio Unitario de Costo</th>
                                <th class="p-4">Factura Asociada (PDF)</th>
                            </tr>
                        </thead>
                        <tbody id="table-repuestos-body" class="divide-y divide-slate-800/60 text-slate-300">
                            @if($repuestos->isEmpty())
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-500 text-xs uppercase tracking-wider">No hay repuestos registrados en la base de datos.</td>
                            </tr>
                            @else
                            @foreach($repuestos as $repuesto)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 font-mono font-medium text-slate-400">{{ $repuesto->codigo_pieza ?? 'S/N' }}</td>
                                <td class="p-4 text-white font-medium">{{ $repuesto->nombre_pieza }}</td>
                                <td class="p-4 font-mono">${{ number_format($repuesto->costo_unitario, 2) }}</td>
                                <td class="p-4 text-sky-400 cursor-pointer hover:underline">
                                    @if($repuesto->factura)
                                    <a href="{{ asset('storage/' . $repuesto->factura->ruta_pdf_almacenamiento) }}" target="_blank">
                                        <i class="fa-solid fa-paperclip mr-1 text-xs"></i>{{ $repuesto->factura->numero_factura }}.pdf
                                    </a>
                                    @else
                                    <span class="text-slate-500">Sin documento</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="border-slate-800">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-[#1e293b] p-5 rounded-xl border border-slate-800 space-y-4 shadow-sm">
                    <h3 class="font-bold text-slate-200 text-sm tracking-wide uppercase border-b border-slate-800 pb-2">
                        <i class="fa-solid fa-pen-nib text-sky-400 mr-1.5"></i> Configurar Correo Manual
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Destinatario (Cliente)</label>
                            <input type="email" id="correo-cliente" value="juan.mendoza@email.com" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-xs text-slate-300 focus:outline-none focus:border-sky-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Asunto predefinido</label>
                            <input type="text" id="asunto-cliente" value="Aviso de Revisión Preventiva - SGA" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-xs text-slate-300 focus:outline-none focus:border-sky-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1">Mensaje o Cuerpo de Plantilla</label>
                            <textarea id="mensaje-cliente" rows="4" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-xs text-slate-300 focus:outline-none focus:border-sky-500 font-sans">Estimado cliente, le saludamos del taller mecánico para informarle que su vehículo está listo...</textarea>
                        </div>
                    </div>
                    <button onclick="enviarNotificacionMantenimiento()" class="w-full bg-sky-500 hover:bg-sky-600 text-slate-900 py-2 rounded-lg font-bold text-xs transition-all cursor-pointer">
                        <i class="fa-solid fa-paper-plane mr-1"></i> Despachar Correo Manual
                    </button>
                </div>

                <div class="bg-[#1e293b] p-5 rounded-xl border border-slate-800 lg:col-span-2 space-y-3 shadow-sm">
                    <h3 class="font-bold text-slate-200 text-sm tracking-wide uppercase border-b border-slate-800 pb-2">
                        <i class="fa-solid fa-clock-rotate-left text-amber-400 mr-1.5"></i> Registro de Trazabilidad de Notificaciones
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-900/40 text-slate-400 border-b border-slate-800">
                                    <th class="p-3">Fecha / Hora</th>
                                    <th class="p-3">Tipo</th>
                                    <th class="p-3">Destinatario</th>
                                    <th class="p-3">Estado de Envío</th>
                                </tr>
                            </thead>
                            <tbody id="table-notificaciones-body" class="divide-y divide-slate-800/50 text-slate-300">
                                @foreach($notificaciones as $noti)
                                <tr>
                                    <td class="p-3 font-mono">{{ $noti->fecha_envio ?? $noti->created_at }}</td>
                                    <td class="p-3">
                                        <span class="bg-purple-500/10 text-purple-400 px-1.5 py-0.5 rounded border border-purple-500/20 font-medium font-mono text-[10px]">
                                            {{ $noti->tipo_envio }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ $noti->destinatario }}</td>
                                    <td class="p-3 text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check mr-1 text-[10px]"></i>Exitoso</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-repuesto" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-[#1e293b] border border-slate-800 w-full max-w-md rounded-xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300">
            <div class="px-6 py-4 bg-slate-900 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-bold text-white text-base">Cargar Repuestos vía Factura PDF</h3>
                <button onclick="closeModal('modal-repuesto')" class="text-slate-400 hover:text-white text-sm"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-6 space-y-4">
                <div class="border-2 border-dashed border-slate-700 hover:border-sky-500/50 rounded-xl p-6 text-center cursor-pointer transition-all bg-slate-900/30 relative">
                    <input type="file" id="comprobante_file" accept=".pdf" class="absolute inset-0 opacity-0 cursor-pointer">
                    <i class="fa-solid fa-file-pdf text-3xl text-slate-500 mb-2"></i>
                    <p class="text-xs font-medium text-slate-300">Selecciona o arrastra el archivo legal (.pdf)</p>
                    <p class="text-[10px] text-slate-500 mt-1">Tamaño máximo recomendado: 5MB</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Cantidad Recibida *</label>
                        <input type="number" id="input-cantidad" placeholder="0" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-xs text-slate-200 focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Costo Unitario ($) *</label>
                        <input type="text" id="input-costo" placeholder="0.00" class="w-full bg-slate-900 border border-slate-800 rounded-lg p-2 text-xs text-slate-200 focus:outline-none focus:border-sky-500">
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-900 border-t border-slate-800 flex justify-end gap-3">
                <button onclick="closeModal('modal-repuesto')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-lg">Cancelar</button>
                <button onclick="procesarFacturaPdf()" class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-slate-900 text-xs font-bold rounded-lg cursor-pointer">Vincular al Stock</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
        iziToast.settings({
            timeout: 4000,
            position: 'topRight',
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutUp'
        });

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div > div').classList.remove('scale-95');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.querySelector('div > div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // ACCIÓN AJAX: CARGAR FACTURA PDF Y REPUESTO
        function procesarFacturaPdf() {
            let pdfFile = document.getElementById('comprobante_file');
            let cantidad = document.getElementById('input-cantidad').value;
            let costo = document.getElementById('input-costo').value;

            if (!pdfFile.files[0] || !cantidad || !costo) {
                iziToast.warning({
                    title: 'Atención',
                    message: 'Por favor complete todos los campos requeridos.'
                });
                return;
            }

            iziToast.info({
                title: 'Conectando',
                message: 'Sincronizando con base de datos MySQL...',
                timeout: 1200
            });

            let form = new FormData();
            form.append('comprobante_pdf', pdfFile.files[0]);
            form.append('cantidad_recibida', cantidad);
            form.append('costo_unitario', costo);
            form.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('repuestos.storePdf') }}", {
                    method: 'POST',
                    body: form
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        closeModal('modal-repuesto');
                        iziToast.success({
                            title: 'Éxito',
                            message: data.message
                        });

                        // Agregar fila en caliente a la tabla
                        let tbody = document.getElementById('table-repuestos-body');
                        let fila = `<tr class="hover:bg-slate-800/30 transition-colors bg-sky-500/5">
                        <td class="p-4 font-mono text-slate-400">${data.data.codigo_pieza}</td>
                        <td class="p-4 text-white font-medium">${data.data.nombre_pieza}</td>
                        <td class="p-4 font-mono">${data.data.costo_unitario}</td>
                        <td class="p-4 text-sky-400 cursor-pointer hover:underline">
                            <a href="${data.data.ruta_pdf}" target="_blank"><i class="fa-solid fa-paperclip mr-1 text-xs"></i>${data.data.factura}.pdf</a>
                        </td>
                    </tr>`;
                        tbody.insertAdjacentHTML('afterbegin', fila);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: data.message
                        });
                    }
                }).catch(() => iziToast.error({
                    title: 'Error',
                    message: 'Fallo de conexión al servidor.'
                }));
        }

        // ACCIÓN AJAX: ENVIAR NOTIFICACIÓN DE SERVICIO COMPLETADO
        function enviarNotificacionMantenimiento() {
            let payload = {
                destinatario: document.getElementById('correo-cliente').value,
                asunto: document.getElementById('asunto-cliente').value,
                mensaje: document.getElementById('mensaje-cliente').value,
                _token: '{{ csrf_token() }}'
            };

            fetch("{{ route('notificaciones.enviar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        iziToast.success({
                            title: 'Enviado',
                            message: 'Notificación registrada e iziToast activo.',
                            icon: 'fa-solid fa-paper-plane'
                        });

                        let tbodyNoti = document.getElementById('table-notificaciones-body');
                        let filaNoti = `<tr>
                        <td class="p-3 font-mono">${data.notificacion.fecha}</td>
                        <td class="p-3"><span class="bg-purple-500/10 text-purple-400 px-1.5 py-0.5 rounded border border-purple-500/20 font-medium text-[10px]">AUTOMÁTICO</span></td>
                        <td class="p-3">${data.notificacion.destinatario}</td>
                        <td class="p-3 text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check mr-1 text-[10px]"></i>Exitoso</td>
                    </tr>`;
                        tbodyNoti.insertAdjacentHTML('afterbegin', filaNoti);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: data.message
                        });
                    }
                }).catch(() => iziToast.error({
                    title: 'Error',
                    message: 'Fallo al despachar alerta.'
                }));
        }
    </script>
</body>

</html>