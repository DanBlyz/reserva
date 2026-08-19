<?php

namespace App\Traits;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissions
{
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'permiso_usuario', 'user_id', 'permiso_id')
            ->withTimestamps();
    }

    public function tienePermiso(string $clave): bool
    {
        // Administrador general tiene todos los permisos automáticamente
        if ($this->rol && ($this->rol->slug === 'admin' || $this->rol->nombre === 'Administrador')) {
            return true;
        }

        // Verificar si el permiso está asignado directamente al usuario
        if ($this->permisos()->where('clave', $clave)->exists()) {
            return true;
        }

        return false;
    }
}
