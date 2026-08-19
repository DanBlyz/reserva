<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoCaja extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'movimientos_caja';

    protected $fillable = [
        'caja_id',
        'sucursal_id',
        'user_id',
        'tipo',
        'categoria',
        'monto',
        'metodo_pago',
        'concepto',
        'recibo_id',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
        ];
    }

    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibo::class, 'recibo_id');
    }
}
