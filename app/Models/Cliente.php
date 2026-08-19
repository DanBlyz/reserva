<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula',
        'nit',
        'fecha_nacimiento',
        'direccion',
        'celular',
        'correo',
        'observaciones_generales',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'cliente_id');
    }

    public function recibos(): HasMany
    {
        return $this->hasMany(Recibo::class, 'cliente_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres} {$this->apellidos}");
    }
}
