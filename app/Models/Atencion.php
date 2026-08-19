<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atencion extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'atenciones';

    protected $fillable = [
        'reserva_id',
        'usuario_atencion_id',
        'diagnostico',
        'observaciones',
        'recomendaciones',
        'subtotal_servicios',
        'cobro_extra',
        'motivo_cobro_extra',
        'descuento',
        'motivo_descuento',
        'monto_total_calculado',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'subtotal_servicios' => 'decimal:2',
            'cobro_extra' => 'decimal:2',
            'descuento' => 'decimal:2',
            'monto_total_calculado' => 'decimal:2',
        ];
    }

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function personalAtencion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_atencion_id');
    }
}
