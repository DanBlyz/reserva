<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('usuario_atencion_id')->constrained('users'); // Personal asignado que atiende
            $table->foreignId('usuario_registro_id')->nullable()->constrained('users'); // Quien creó la reserva
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'en_atencion',
                'atendida',
                'en_caja',
                'completada',
                'reprogramada',
                'cancelada',
                'no_asistio',
            ])->default('pendiente');

            $table->text('motivo_cancelacion')->nullable();
            $table->text('motivo_reprogramacion')->nullable();
            $table->text('notas_reserva')->nullable();

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
        Schema::dropIfExists('reservas');
    }
};
