<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'reservas';

    protected $fillable = [
        'codigo',
        'sucursal_id',
        'cliente_id',
        'usuario_atencion_id',
        'usuario_registro_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'motivo_cancelacion',
        'motivo_reprogramacion',
        'notas_reserva',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function personalAtencion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_atencion_id');
    }

    public function usuarioRegistro(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_registro_id');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'reserva_servicio', 'reserva_id', 'servicio_id')
            ->withPivot('precio_aplicado', 'duracion_minutos')
            ->withTimestamps();
    }

    public function atencion(): HasOne
    {
        return $this->hasOne(Atencion::class, 'reserva_id');
    }

    public function recibo(): HasOne
    {
        return $this->hasOne(Recibo::class, 'reserva_id');
    }
}
