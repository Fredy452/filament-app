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
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('proveedors_id')->nullable()->after('categoria_producto_id');

            $table->foreign('proveedors_id')
                ->references('id')
                ->on('proveedors')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropForeign(['proveedors_id']);
                $table->dropColumn('proveedors_id');
            });
        });
    }
};
