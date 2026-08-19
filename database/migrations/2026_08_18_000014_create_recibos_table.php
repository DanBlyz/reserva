<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recibo')->unique();
            $table->foreignId('caja_id')->constrained('cajas');
            $table->foreignId('reserva_id')->nullable()->constrained('reservas')->nullOnDelete();
            $table->foreignId('atencion_id')->nullable()->constrained('atenciones')->nullOnDelete();
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('usuario_cajero_id')->constrained('users');

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('cobros_extras', 10, 2)->default(0);
            $table->decimal('descuentos', 10, 2)->default(0);
            $table->decimal('monto_total', 10, 2)->default(0);
            $table->decimal('monto_pagado', 10, 2)->default(0);
            $table->decimal('cambio', 10, 2)->default(0);

            $table->enum('metodo_pago', ['efectivo', 'qr', 'tarjeta', 'transferencia'])->default('efectivo');
            $table->enum('estado', ['emitido', 'anulado'])->default('emitido');
            $table->text('observaciones')->nullable();

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
        Schema::dropIfExists('recibos');
    }
};
