<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    
    protected $fillable = [
        'username',
        'password_hash',
        'estado_activo',
        'id_rol',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'estado_activo' => 'boolean',
    ];

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    // Se activará en la rama de Roles
    // public function rol(): BelongsTo
    // {
    //     return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    // }

    // Se activará en la rama de Auditoría
    // public function historialCambios(): HasMany
    // {
    //     return $this->hasMany(HistorialCambio::class, 'id_usuario', 'id_usuario');
    // }
}