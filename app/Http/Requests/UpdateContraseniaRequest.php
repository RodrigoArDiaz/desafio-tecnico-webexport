<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateContraseniaRequest extends FormRequest
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
        return [
            'contrasenia_actual' => 'required|min:8',
            'contrasenia' => 'required|min:8|confirmed',
        ];
        
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $usuario = Usuario::find($this->route('usuario'));
            if ($usuario && !Hash::check($this->input('contrasenia_actual'), $usuario->contrasenia)) {
                $validator->errors()->add('contrasenia_actual', 'La contraseña actual es incorrecta.');
            }
        });
    }
}
