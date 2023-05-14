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
        Schema::table('ventas', function (Blueprint $table) {
            $table->renameColumn('estado_pago_id', 'estado_pagos_id');
            $table->renameColumn('metodo_pago_id', 'metodo_pagos_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->renameColumn('estado_pagos_id', 'estado_pago_id');
            $table->renameColumn('metodo_pagos_id', 'metodo_pago_id');
        });
    }
};
