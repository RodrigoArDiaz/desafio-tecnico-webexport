<?php

namespace Tests\Feature;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermisoRolTest extends TestCase
{
    use RefreshDatabase;

    /** 
      * Verifica que se asigne permiso a rol correctament.
    */
    public function test_rol_puede_agregar_permiso()
    {
        $permiso = Permiso::factory()->create();

        $rol = Rol::factory()->create();

        $rol->permisos()->attach($permiso->id);

        $this->assertTrue($rol->permisos->contains($permiso));
    }

    /** 
      * Verifica que se asignen multiples permisos a rol correctament.
    */
    public function test_rol_puede_agregar_multiples_permisos()
    {
        $rol = Rol::factory()->create();

        $permiso1 = Permiso::factory()->create();
        $permiso2 = Permiso::factory()->create();

        $rol->permisos()->attach([$permiso1->id, $permiso2->id]);
        $this->assertTrue($rol->permisos->contains($permiso1));
        $this->assertTrue($rol->permisos->contains($permiso2));
    }

    /** 
      * Verifica que se asignen un mismo permiso a multiples roles correctamente.
    */
    public function test_permiso_puede_agregarse_a_multiples_roles()
    {
        $permiso = Permiso::factory()->create();

        $rol1 = Rol::factory()->create();
        $rol2 = Rol::factory()->create();

        $permiso->roles()->attach([$rol1->id, $rol2->id]);
        $this->assertTrue($permiso->roles->contains($rol1));
        $this->assertTrue($permiso->roles->contains($rol2));
    }

    /** Verifica que rol no tenga permisos duplicados.
    */
    public function test_rol_no_puede_tener_permiso_duplicado()
    {
        $rol = Rol::factory()->create();

        $permiso = Permiso::factory()->create();

        $rol->permisos()->attach($permiso->id);

        // Se verifica que se lance una excepción si se intenta asignar el permiso nuevamente.
        $this->expectException(QueryException::class);

        // Se intenta asignar permiso duplicado
        $rol->permisos()->attach($permiso->id);
    }
}
