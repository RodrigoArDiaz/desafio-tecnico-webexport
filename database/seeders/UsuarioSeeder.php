<?php

namespace Database\Seeders;

use App\Enums\EstadoUsuario;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        //Creacion de superadministrador con privilegios en CRUD de usuarios y roles
        Usuario::factory()->create([
            'mail' => 'superadministrador@gmail.com',
            'contrasenia' => 'super@1234',
            'estado' => EstadoUsuario::ALTA->value,
            'es_super_administrador' => 1 //Solo a fines de prueba
         ]);
        //Creacion de otros usuarios
        Usuario::factory()->count(2)->create(['estado' => EstadoUsuario::ALTA->value]);
        Usuario::factory()->count(1)->create(['estado' => EstadoUsuario::BAJA->value]);
        Usuario::factory()->count(1)->create(['estado' => EstadoUsuario::SUSPENDIDO->value]);
    }
}
