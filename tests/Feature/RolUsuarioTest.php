<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolUsuarioTest extends TestCase
{
    use RefreshDatabase; 

    /** Verifica que se asigne un rol a un usuario correctamente.
    */
    public function test_usuario_puede_agregar_rol()
    {
        $usuario = Usuario::factory()->create();

        $rol = Rol::factory()->create();

        $usuario->roles()->attach($rol->id);

        $this->assertTrue($usuario->roles->contains($rol));
    }

    /** Verifica que se asigne varios roles a un usuario correctamente.
    */
    public function test_usuario_puede_tener_varios_roles()
    {
        $usuario = Usuario::factory()->create();

        $rol1 = Rol::factory()->create();
        $rol2 = Rol::factory()->create();

        $usuario->roles()->attach([$rol1->id, $rol2->id]);

        $this->assertTrue($usuario->roles->contains($rol1));
        $this->assertTrue($usuario->roles->contains($rol2));
    }

    /** Verifica que un rol se asigne a varios usuarios correctamente.
    */
    public function test_rol_puede_ser_asignado_a_varios_usuarios()
    {
        $rol = Rol::factory()->create();

        $usuario1 = Usuario::factory()->create();
        $usuario2 = Usuario::factory()->create();

        $rol->usuarios()->attach([$usuario1->id, $usuario2->id]);

        $this->assertTrue($rol->usuarios->contains($usuario1));
        $this->assertTrue($rol->usuarios->contains($usuario2));
    }

    /** Verifica que un rol no asigne  mas de una vez a un mismo usuario.
    */
    public function test_usuario_no_puede_tener_rol_duplicado()
    {
        $rol = Rol::factory()->create();

        $usuario = Usuario::factory()->create();

        $usuario->roles()->attach($rol->id);

        // Se verifica que se lance una excepción si se intenta asignar el rol nuevamente.
        $this->expectException(QueryException::class);

        // Se intenta asignar rol duplicado
        $usuario->roles()->attach($rol);
    }
}
