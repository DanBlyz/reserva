<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recibo extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'recibos';

    protected $fillable = [
        'numero_recibo',
        'caja_id',
        'reserva_id',
        'atencion_id',
        'sucursal_id',
        'cliente_id',
        'usuario_cajero_id',
        'subtotal',
        'cobros_extras',
        'descuentos',
        'monto_total',
        'monto_pagado',
        'cambio',
        'metodo_pago',
        'estado',
        'observaciones',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'cobros_extras' => 'decimal:2',
            'descuentos' => 'decimal:2',
            'monto_total' => 'decimal:2',
            'monto_pagado' => 'decimal:2',
            'cambio' => 'decimal:2',
        ];
    }

    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function atencion(): BelongsTo
    {
        return $this->belongsTo(Atencion::class, 'atencion_id');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function cajero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_cajero_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleRecibo::class, 'recibo_id');
    }
}
