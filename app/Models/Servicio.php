<?php

namespace App\Models;

use App\Traits\HasAuditColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasAuditColumns, SoftDeletes;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_base',
        'duracion_minutos',
        'color',
        'activo',
        'usuario_creador_id',
        'usuario_modificador_id',
        'usuario_eliminador_id',
    ];

    protected function casts(): array
    {
        return [
            'precio_base' => 'decimal:2',
            'duracion_minutos' => 'integer',
            'activo' => 'boolean',
        ];
    }
}
