<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';

    protected $primaryKey = 'id_mantenimiento';

    protected $fillable = [
        'fecha_servicio',
        'descripcion_falla',
        'estado',
        'costo_mano_obra',
        'id_vehiculo'
    ];
}