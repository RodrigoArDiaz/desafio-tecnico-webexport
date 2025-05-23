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
        Schema::create('permiso_rol', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permiso_id');
            $table->unsignedBigInteger('rol_id');

            $table->foreign('permiso_id')
                ->references('id')
                ->on('permisos')
                ->onDelete('restrict');

            $table->foreign('rol_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');

            $table->unique(['permiso_id', 'rol_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_rol');
    }
};
