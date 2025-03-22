<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que vista de lista de usuarios se cargue correctamente
     */
    public function test_ruta_de_lista_de_usuarios_devuelve_la_vista_correcta()
    {
        Usuario::factory()->count(3)->create();

        $response = $this->get(route('usuarios.index'));

        $response->assertStatus(200);

        $response->assertViewIs('usuarios.index');

        $response->assertViewHas('usuarios');

        $usuarios = Usuario::all();
        foreach ($usuarios as $usuario) {
            $response->assertSee($usuario->name);
        }
    }
}