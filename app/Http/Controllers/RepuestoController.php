<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repuesto;
use App\Models\Factura;
use App\Models\Notificacion;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class RepuestoController extends BaseController
{
    // Requerimiento A: Ver repuestos con trazabilidad e historial en el Dashboard SPA
    public function index()
    {
        // Cargamos los repuestos con la info de su factura asociada (Eager Loading)
        $repuestos = Repuesto::with('factura')->get();

        // Cargamos las últimas alertas/notificaciones indexadas para la vista lateral
        $notificaciones = Notificacion::orderBy('id_notificacion', 'desc')->get();

        // Retornamos tu vista (basada en el árbol de carpetas que pasaste)
        return view('repuestos.index', compact('repuestos', 'notificaciones'));
    }

    // Requerimiento B: Registrar repuesto y datos de facturación procesando el PDF
    public function storeFromPdf(Request $request)
    {
        // Validaciones estrictas según los tipos de datos de tus columnas
        $request->validate([
            'comprobante_pdf' => 'required|mimes:pdf|max:5120',
            'cantidad_recibida' => 'required|integer|min:1',
            'costo_unitario' => 'required|numeric|min:0'
        ]);

        try {
            // Guardar el archivo PDF en el disco local ('storage/app/public/facturas')
            $path = $request->file('comprobante_pdf')->store('facturas', 'public');

            // Simulación de extracción OCR basada en los datos reales del UI que nos mandaste
            $numFacturaSimulado = 'FAC-' . rand(8000, 9999);
            $nombrePiezaSimulado = 'Pastillas de Freno Cerámicas Delanteras Premium';
            $codigoPiezaSimulado = 'REP-' . rand(2000, 4000) . '-A';

            $costoUnitario = $request->input('costo_unitario');
            $cantidad = $request->input('cantidad_recibida');
            $montoTotal = $costoUnitario * $cantidad;

            // 1. Insertar en la tabla 'facturas'
            $factura = Factura::create([
                'numero_factura' => $numFacturaSimulado,
                'fecha_emision' => now()->format('Y-m-d'),
                'monto_total' => $montoTotal,
                'ruta_pdf_almacenamiento' => $path
            ]);

            // 2. Insertar en la tabla 'repuestos' vinculando el id_factura generado
            $repuesto = Repuesto::create([
                'nombre_pieza' => $nombrePiezaSimulado,
                'codigo_pieza' => $codigoPiezaSimulado,
                'costo_unitario' => $costoUnitario,
                'id_factura' => $factura->id_factura
                //'id_proveedor' => null // <--- CAMBIA EL 1 POR null AQUÍ
            ]);


            return response()->json([
                'success' => true,
                'message' => '¡Factura vinculada y stock actualizado exitosamente!',
                'data' => [
                    'id_repuesto' => $repuesto->id_repuesto,
                    'codigo_pieza' => $repuesto->codigo_pieza,
                    'nombre_pieza' => $repuesto->nombre_pieza,
                    'costo_unitario' => '$' . number_with_metas($repuesto->costo_unitario),
                    'factura' => $factura->numero_factura,
                    'ruta_pdf' => asset('storage/' . $factura->ruta_pdf_almacenamiento)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en base de datos al procesar la factura: ' . $e->getMessage()
            ], 500);
        }
    }

    // Requerimiento C: Registrar alerta interna y simular despacho de correo de mantenimiento completado
    public function enviarNotificacion(Request $request)
    {
        $request->validate([
            'destinatario' => 'required|email|max:100',
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string'
        ]);

        try {
            // Guardar el registro en la tabla de notificaciones
            $notificacion = Notificacion::create([
                'destinatario' => $request->input('destinatario'),
                'asunto' => $request->input('asunto'),
                'mensaje' => $request->input('mensaje'),
                'tipo_envio' => 'AUTOMÁTICO', // O 'MANUAL' según controles desde el UI
                'fecha_envio' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notificación registrada en el sistema SGA.',
                'notificacion' => [
                    'fecha' => $notificacion->fecha_envio->format('Y-m-d H:i'),
                    'destinatario' => $notificacion->destinatario
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar o despachar la alerta: ' . $e->getMessage()
            ], 500);
        }
    }
}

// Función auxiliar simple para dar formato de moneda limpia a los responses
function number_with_metas($value)
{
    return number_format($value, 2, '.', ',');
}
