<?php

namespace Tests\Unit;

use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolControllerTest extends TestCase
{
    use RefreshDatabase;

     /**
     * Verifica que un rol  puede ser creado correctamente.
     */
    public function test_store_usuario()
    {   
        $permiso = Permiso::factory()->create();
        $data = [
            'nombre' => 'Administrador',
            'permisos' => [$permiso->id]
        ];
        $response = $this->post(route('roles.store'), $data);

        // Verifica que el usuario fue creado en la base de datos
        unset($data['permisos']);
        $this->assertDatabaseHas('roles', $data);

        // Obtiene el rol recién creado
        $rol = Rol::where('nombre', 'Administrador')->first();

        // Verifica que el permiso fue asignado al rol en la tabla intermedia
        $this->assertDatabaseHas('permiso_rol', [
            'rol_id' => $rol->id,
            'permiso_id' => $permiso->id,
        ]);

        // Verifica que la respuesta redirige a la lista de roles
        $response->assertRedirect(route('roles.index'));
    }

    /**
     * Verifica que el rol pueda ser eliminado correctamente.
     */
    public function test_delete_rol()
    {
        $rol = Rol::factory()->create();

        $response = $this->delete(route('roles.destroy', $rol->id));

        $response->assertRedirect(route('roles.index'));

        // Verificar que el rol ya no existe en la base de datos
        $this->assertDatabaseMissing('roles', [
            'id' => $rol->id,
        ]);
    }

    /** 
      * Verifica que rol asignado a usuario/s pueda ser eliminado correctamente
    */
    public function test_delete_rol_con_usuarios_asignados()
    {
        $rol = Rol::factory()->create();

        $usuario1 = Usuario::factory()->create();
        $usuario2 = Usuario::factory()->create();

        $rol->usuarios()->attach([$usuario1->id, $usuario2->id]);

        $response = $this->delete(route('roles.destroy', $rol->id));

        $response->assertRedirect(route('roles.index'));

        // Verificar que el usuario ya no existe en la base de datos
        $this->assertDatabaseMissing('roles', [
            'id' => $rol->id,
        ]);
    }

}