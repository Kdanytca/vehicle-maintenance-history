<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable = [
    'id_mantenimiento',
    'fecha_servicio',
    'descripcion_falla',
    'mecanico_responsable',
    'estado',
    'costo_mano_obra',
    'id_vehiculo'
];
}
