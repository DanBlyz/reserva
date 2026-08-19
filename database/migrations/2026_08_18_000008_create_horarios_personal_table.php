<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->nullOnDelete();
            $table->tinyInteger('dia_semana'); // 0 = Domingo, 1 = Lunes, ..., 6 = Sábado
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('activo')->default(true);

            // Auditoría
            $table->foreignId('usuario_creador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('usuario_modificador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('usuario_eliminador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_personal');
    }
};
