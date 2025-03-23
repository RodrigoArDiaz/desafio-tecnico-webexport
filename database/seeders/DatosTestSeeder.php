<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatosTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ejecutar otros seeders
        $this->call([
            //Crear usuarios
            UsuarioSeeder::class,
            //Crear permisos predefinidos
            PermisoPredefinidoSeeder::class
        ]);
    }
}
