<?php

namespace Tests\Unit;

use App\Enums\Genero;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioControllerTest extends TestCase
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

    /**
     * Verifica que un usuario puede ser creado correctamente.
     */
    public function test_store_usuario()
    {
        $data = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
            'mail' => 'juan@example.com',
            'fecha_de_nacimiento' => '1990-01-01',
            'genero' => Genero::NO_BINARIO->value,
            'contrasenia' => 'password123',
            'contrasenia_confirmation' => 'password123',
        ];
        $response = $this->post(route('usuarios.store'), $data);

        // Verifica que el usuario fue creado en la base de datos
        $this->assertDatabaseHas('usuarios', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
            'mail' => 'juan@example.com',
        ]);

        // Verifica que la respuesta redirige a la lista de usuarios
        $response->assertRedirect(route('usuarios.index'));
    }

    /**
     * Verifica la validación de campos requeridos.
     */
    public function test_store_usuario_validacion_campos_requeridos()
    {
        // Solicitud POST sin datos
        $response = $this->post(route('usuarios.store'), []);

        // Verifica que la respuesta contiene errores de validación
        $response->assertSessionHasErrors([
            'nombre',
            'apellido',
            'dni',
            'mail',
            'fecha_de_nacimiento',
            'genero',
            'contrasenia',
        ]);
    }

    /**
     * Verificar la validación del campo DNI único.
     */
    public function test_store_usuario_validacion_dni_unico()
    {
        Usuario::factory()->create(['dni' => '12345678']);

        $dataOtroUsuario = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678', // DNI duplicado
            'mail' => 'juan@example.com',
            'fecha_de_nacimiento' => '1990-01-01',
            'genero' => Genero::MASCULINO->value,
            'contrasenia' => 'password123',
            'contrasenia_confirmation' => 'password123',
        ];

        $response = $this->post(route('usuarios.store'), $dataOtroUsuario);

        // Verifica que la respuesta contiene un error de validación para el DNI
        $response->assertSessionHasErrors('dni');
    }

    /**
     * Test para verificar la validación del campo correo único.
     */
    public function test_store_usuario_validacion_mail_unico()
    {
        Usuario::factory()->create(['mail' => 'juan@example.com']);

        $dataOtroUsuario = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'dni' => '12345678',
            'mail' => 'juan@example.com', // Correo duplicado
            'fecha_de_nacimiento' => '1990-01-01',
            'genero' => Genero::MASCULINO->value,
            'contrasenia' => 'password123',
            'contrasenia_confirmation' => 'password123',
        ];

        $response = $this->post(route('usuarios.store'), $dataOtroUsuario);

        // Verifica que la respuesta contiene un error de validación para el correo
        $response->assertSessionHasErrors('mail');
    }
}