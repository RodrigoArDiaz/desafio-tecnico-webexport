<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisoPredefinidoSeeder extends Seeder
{
    /**
     * Listado de nombres de permisos a crear.
     *
     * @var array
     */
    protected $permisos = [
        'ver_cursos',
        'crear_cursos',
        'editar_cursos',
        'eliminar_cursos',
        'ver_productos',
        'crear_productos',
        'editar_productos',
        'eliminar_productos',
    ];

    /**
     * Ejecuta el seeder.
     *
     * @return void
     */
    public function run()
    {
        // Recorre el listado de nombres de permisos
        foreach ($this->permisos as $permiso) {
            // Crea un permiso en la base de datos
            Permiso::create([
                'nombre' => $permiso,
            ]);
        }

        $this->command->info('Permisos creados exitosamente.');
    }
}