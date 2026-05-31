<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    protected $table = 'propietarios';

    protected $primaryKey = 'id_propietario';

    protected $fillable = [
        'nombre',
        'documento_identidad',
        'telefono',
        'correo'
    ];

    public function vehiculos()
    {
        return $this->hasMany(
            Vehiculo::class,
            'id_propietario',
            'id_propietario'
        );
    }
}
