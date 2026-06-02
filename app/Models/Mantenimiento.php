<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable = [
    'id_mantenimiento',
    'fecha_servicio',
    'descripcion_falla',
    'estado',
    'costo_mano_obra',
    'id_vehiculo'
];

public function vehiculo()
{
    return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
}

}
