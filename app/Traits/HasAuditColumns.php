<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

trait HasAuditColumns
{
    public static function bootHasAuditColumns(): void
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->usuario_creador_id)) {
                $model->usuario_creador_id = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->usuario_modificador_id = Auth::id();
            }
        });

        if (in_array(SoftDeletes::class, class_uses_recursive(static::class))) {
            static::deleting(function ($model) {
                if (Auth::check() && ! $model->isForceDeleting()) {
                    $model->usuario_eliminador_id = Auth::id();
                    $model->saveQuietly();
                }
            });
        }
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_creador_id');
    }

    public function modificador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_modificador_id');
    }

    public function eliminador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_eliminador_id');
    }
}
