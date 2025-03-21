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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('dni', 20)->unique();
            $table->string('mail', 320)->unique();
            $table->date('fecha_de_nacimiento');
            $table->string('genero', 50);
            $table->string('contrasenia', 80);
            $table->boolean('es_super_administrador')->default(false);
            $table->timestamp('fecha_creacion')->useCurrent();;
            $table->timestamp('fecha_modificacion')->useCurrent();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
