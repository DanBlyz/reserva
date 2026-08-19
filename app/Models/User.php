<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string|null $nombres
 * @property string|null $ap_paterno
 * @property string|null $ap_materno
 * @property int|null $sucursal_id
 * @property int|null $rol_id
 *
 * @method bool tienePermiso(string $clave)
 */
class User extends Authenticatable
{
    use HasAuditColumns, HasFactory, HasPermissions, Notifiable, SoftDeletes;

    protected $fillable = [
        'nombres',
        'ap_paterno',
        'ap_materno',
        'name',
        'cedula',
        'direccion',
        'celular',
        'email',
        'password',
        'sucursal_id',
        'rol_id',
        'activo',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(HorarioPersonal::class, 'user_id');
    }

    public function reservasAsignadas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'usuario_atencion_id');
    }

    public function cajas(): HasMany
    {
        return $this->hasMany(Caja::class, 'user_id');
    }

    /**
     * Nombre completo formateado
     */
    public function getNombreCompletoAttribute(): string
    {
        if ($this->nombres) {
            return trim("{$this->nombres} {$this->ap_paterno} {$this->ap_materno}");
        }

        return $this->name;
    }
}
