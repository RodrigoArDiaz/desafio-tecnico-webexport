<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Refresca la base de datos antes de cada prueba

    /**
     * Verifica que un usuario puede iniciar sesión con credenciales válidas
     */
    public function test_usuario_puede_iniciar_sesion()
    {
        $usuario = Usuario::factory()->create([
            'mail' => 'usuario@example.com',
            'contrasenia' => 'password123', 
        ]);

        $response = $this->post('/login', [
            'mail' => 'usuario@example.com',
            'contrasenia' => 'password123',
        ]);

        // Verifica que el usuario fue autenticado
        $this->assertAuthenticatedAs($usuario);
    }

    /**
     * Verifica que un usuario no puede iniciar sesión con credenciales inválidas
     */
    public function test_usuario_no_puede_iniciar_sesion_con_credenciales_invalidas()
    {
        $usuario = Usuario::factory()->create([
            'mail' => 'usuario@example.com',
            'contrasenia' => bcrypt('password123'),
        ]);

        // Intentar iniciar sesión con credenciales inválidas
        $response = $this->post('/login', [
            'mail' => 'usuario@example.com',
            'contrasenia' => 'contraseña-incorrecta',
        ]);

        // Verificar que el usuario no fue autenticado
        $this->assertGuest();

        // Verificar que la respuesta contiene un mensaje de error
        $response->assertSessionHasErrors('mail');
    }

    /**
     * Verifica que un usuario puede cerrar sesión.
     */
    public function test_usuario_puede_cerrar_sesion()
    {
        $usuario = Usuario::factory()->create();

        $this->actingAs($usuario);

        $response = $this->post('/logout');

        // Verificar que el usuario dejo de estar autenticado
        $this->assertGuest();

        // Verificar que la respuesta redirige a la página de inicio
        $response->assertRedirect('/');
    }
}