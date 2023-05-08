<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->string('numero_factura');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('metodo_pago_id');
            $table->unsignedBigInteger('estado_pago_id');
            $table->decimal('total_venta', 8, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pagos');
            $table->foreign('estado_pago_id')->references('id')->on('estado_pagos');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
