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
        Schema::create('rol_usuario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('rol_id');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('restrict');

            $table->foreign('rol_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');

            $table->unique(['usuario_id', 'rol_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_usuario');
    }
};
