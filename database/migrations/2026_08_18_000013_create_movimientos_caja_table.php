<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_caja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->constrained('cajas')->cascadeOnDelete();
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('user_id')->constrained('users'); // Usuario que registró el movimiento
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->string('categoria'); // Ej: 'cobro_recibo', 'pago_deuda', 'gasto_almuerzo', 'gasto_insumos', 'otro'
            $table->decimal('monto', 10, 2);
            $table->enum('metodo_pago', ['efectivo', 'qr', 'tarjeta', 'transferencia'])->default('efectivo');
            $table->string('concepto');
            $table->unsignedBigInteger('recibo_id')->nullable();

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
        Schema::dropIfExists('movimientos_caja');
    }
};
