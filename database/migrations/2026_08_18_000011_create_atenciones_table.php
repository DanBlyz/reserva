<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas')->cascadeOnDelete();
            $table->foreignId('usuario_atencion_id')->constrained('users'); // Personal que brindó la atención

            $table->text('diagnostico')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('recomendaciones')->nullable();

            $table->decimal('subtotal_servicios', 10, 2)->default(0);
            $table->decimal('cobro_extra', 10, 2)->default(0);
            $table->text('motivo_cobro_extra')->nullable();
            $table->decimal('descuento', 10, 2)->default(0);
            $table->text('motivo_descuento')->nullable();
            $table->decimal('monto_total_calculado', 10, 2)->default(0);

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
        Schema::dropIfExists('atenciones');
    }
};
