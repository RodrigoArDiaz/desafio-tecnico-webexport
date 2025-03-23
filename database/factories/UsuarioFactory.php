<?php

namespace Database\Factories;

use App\Enums\EstadoUsuario;
use App\Enums\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'dni' => $this->faker->unique()->numerify('########'), // DNI aleatorio
            'mail' => $this->faker->unique()->safeEmail,
            'fecha_de_nacimiento' => $this->faker->date('Y-m-d', '2005-01-01'),
            'genero' => $this->faker->randomElement(Genero::cases()),
            'contrasenia' => 'usuario@1234',
            'estado' => $this->faker->randomElement(EstadoUsuario::cases()),
        ];
    }
}
