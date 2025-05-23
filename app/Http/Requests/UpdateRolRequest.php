<?php

namespace App\Http\Requests;

use App\Enums\EstadoRol;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRolRequest extends FormRequest
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
        $rolId = $this->route('rol');

        $estados = implode(',', array_map(fn($estado) => $estado->value, EstadoRol::cases()));

        return [
            'nombre' => 'required|string|max:100|unique:roles,nombre,'.$rolId,
            'estado' => "in:{$estados}",
            'permisos' => 'required|array', 
            'permisos.*' => 'integer|exists:permisos,id',
        ];
    }
}
