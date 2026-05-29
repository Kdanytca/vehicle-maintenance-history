<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'username' => $this->username,
            'estado_activo' => (bool) $this->estado_activo,
            'rol' => [
                'id_rol' => $this->id_rol,
                'nombre_rol' => $this->nombre_rol_temporal,
            ],
        ];
    }
}