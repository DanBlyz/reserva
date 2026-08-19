<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caja extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'cajas';

    protected $fillable = [
        'sucursal_id',
        'user_id',
        'monto_apertura',
        'monto_cierre',
        'monto_efectivo_calculado',
        'monto_efectivo_real',
        'diferencia',
        'fecha_apertura',
        'fecha_cierre',
        'estado',
        'observaciones',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'monto_apertura' => 'decimal:2',
            'monto_cierre' => 'decimal:2',
            'monto_efectivo_calculado' => 'decimal:2',
            'monto_efectivo_real' => 'decimal:2',
            'diferencia' => 'decimal:2',
            'fecha_apertura' => 'datetime',
            'fecha_cierre' => 'datetime',
        ];
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function cajero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoCaja::class, 'caja_id');
    }

    public function recibos(): HasMany
    {
        return $this->hasMany(Recibo::class, 'caja_id');
    }
}
