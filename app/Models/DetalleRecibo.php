<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleRecibo extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'detalle_recibos';

    protected $fillable = [
        'recibo_id',
        'servicio_id',
        'concepto',
        'cantidad',
        'precio_unitario',
        'descuento_aplicado',
        'subtotal',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
            'descuento_aplicado' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibo::class, 'recibo_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
