<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioPermisoTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * Verifica que usuario tenga un permiso dado.
    */
    public function test_usuario_puede_tener_un_permiso()
    {
        $usuario = Usuario::factory()->create();

        $rol = Rol::factory()->create();

        $permiso = Permiso::factory()->create(['nombre' => 'editar_usuarios']);

        $rol->permisos()->attach($permiso);

        $usuario->roles()->attach($rol);

        // Verifica que el usuario tiene el permiso
        $this->assertTrue($usuario->tienePermiso('editar_usuarios'));
    }

    /**
     * Verifica que un usuario no tenga un permiso si no tiene el rol correcto.
     * */
    public function test_usuario_no_tiene_un_permiso_si_no_tiene_el_rol_correcto()
    {
        $usuario = Usuario::factory()->create();

        $rol = Rol::factory()->create();

        $permiso = Permiso::factory()->create(['nombre' => 'editar_usuarios']);

        $otroRol = Rol::factory()->create();
        $otroRol->permisos()->attach($permiso);

        $usuario->roles()->attach($rol);

        // Verifica que el usuario no tiene el permiso
        $this->assertFalse($usuario->tienePermiso('editar_usuarios'));
    }

    
    /**
     * Verifica que un usuario no tenga ningun permiso si no tiene rol asignado.
     * */
    public function test_usuario_no_tiene_un_permiso_si_no_tiene_ningun_rol()
    {
        $usuario = Usuario::factory()->create();
        
        $this->assertFalse($usuario->tienePermiso('editar_usuarios'));
    }
}