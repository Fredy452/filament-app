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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripción');
            $table->decimal('precio', 8, 2);
            $table->unsignedBigInteger('medida_id');
            $table->integer('stock');
            $table->unsignedBigInteger('categoria_producto_id');
            $table->boolean('promocion')->default(false);
            $table->foreign('categoria_producto_id')->references('id')->on('categoria_producto');
            $table->foreign('medida_id')->references('id')->on('medida');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
