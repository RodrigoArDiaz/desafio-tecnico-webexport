<?php

namespace App\Http\Requests;

use App\Enums\Genero;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $usuarioId = $this->route('usuario');

        $generos = implode(',', array_map(fn($genero) => $genero->value, Genero::cases()));

        return [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'required|numeric|digits_between:1,8|unique:usuarios,dni,' . $usuarioId,
            'mail' => 'required|email|max:320|unique:usuarios,mail,' . $usuarioId,
            'fecha_de_nacimiento' => 'required|date|before:today',
            'genero' => "required|in:{$generos}",
            'contrasenia' => 'nullable|min:8|confirmed', 
        ];
    }
}
