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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_cliente_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('direccion');
            $table->string('telefono', 20);
            $table->string('correo')->unique();
            $table->date('fecha_registro');
            $table->decimal('total_gasto', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
